<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Exceptions\ValidatorException;
use App\Http\Resources\BaseResource;
use App\Http\Resources\PostmetaResource;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Models\Attachment;
use App\Http\Resources\AttachmentCollection;
use App\Http\Resources\AttachmentResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AttachmentController extends Controller
{
    public function index() {
        $attachments = Attachment::all();
        $collection = new AttachmentCollection($attachments);

        return $collection
            ->success()
            ->setCode(200)
            ->setMessage("Attachment list loaded successfully");
    }

    public function show(int $id) {
        $attachment = Attachment::FindOrFail($id);
        $resource = new AttachmentResource($attachment);

        return $resource
            ->success()
            ->setCode(200)
            ->setMessage("Attachment retrieved successfully");
    }

    public function store(int $topicId, int $postId, Request $request) {
        $topic = Topic::find($topicId);
        $post = Post::find($postId);
        if (!$topic) throw new NotFoundException("Not found", json_encode(["not_found"=> "The topic you're trying to access was not found"]));
        if (!$post) throw new NotFoundException("Not found", json_encode(["not_found"=> "The post you're trying to access was not found"]));

        $this->authorize("create", [Attachment::class, $topic, $post]);

        $validator = Validator::make($request->all(), [
            "post_slug"=> "required|string",
            "attachment_file"=> "file|image", //"required|file|image"
            "postmeta_alt"=> "string|nullable",
            "postmeta_title"=> "string|nullable"
        ]);

        if ($validator->fails()) throw new ValidatorException("Data validation failed", json_encode($validator->errors()));

        $data = array(
            "post_type"=> "attachment",
            "post_author"=> Auth::id(),
            "post_parent"=> $topicId,
            "post_content"=> $request->get("post_content"),
        );

        if (!$request->hasFile("attachment_file") || !$request->file("attachment_file")->isValid()) {
            throw new ValidatorException("Invalid file provided", json_encode($request->hasFile("attachment_file") ? ["invalid_file"=> "The file is not valid, verify if this file is an image and in supported format"] : ["any_file"=> "Any file was send."] ));
        }

        $file = $request->file("attachment_file");
        $filename = pathinfo($request->get("post_slug"), PATHINFO_FILENAME) . "-" .$file->hashName();
        $path = $file->storeAs("public/uploads", $filename);
        $full_path = storage_path() . "/app/". $path;

        $data["post_slug"] = $filename;
        $sizes = [
            "width"=> getimagesize($full_path)[0],
            "height"=> getimagesize($full_path)[1],
        ];

        if (!file_exists($full_path)) {
            return BaseResource::error()
                ->setCode(500)
                ->setMessage("Failed to save the file")
                ->setErrors(json_encode(["save_error" => "Failed to save the file to the server."]));
        }

        $metadata = array(
            "alt_text"=> $request->get("postmeta_alt"),
            "title"=> $request->get("postmeta_title"),
            "ratio"=> ratio($sizes),
            "format"=> pathinfo($filename, PATHINFO_EXTENSION)
        );
        $attachment = Attachment::create($data);
        $attachment->metas()->create([
            "post_id"=> $attachment->post_id,
            "meta_key"=> "_meta_attachment_metadata",
            "meta_value"=> serialize($metadata)
        ]);
        $attachment->metas()->create([
            "post_id"=> $attachment->post_id,
            "meta_key"=> "_meta_attachment_file",
            "meta_value"=> str_replace("public/", "", $path)
        ]);
        $resource = new AttachmentResource($attachment);

        return $resource
            ->success()
            ->setCode(201)
            ->setMessage("Attachment upload successfully");
    }

    public function update(Request $request, int $id)
    {
        // Récupération de l'attachement existant
        $attachment = Attachment::find($id);

        if (!$attachment) throw new NotFoundException("Not found", json_encode(["not_found"=> "The attachment you're trying to edit is not found"]));

        $this->authorize("update", [$attachment]);

        // Validation des données envoyées dans la requête
        $validator = Validator::make($request->all(), [
            "post_slug" => "string|nullable", // Le slug est optionnel
            "postmeta_alt" => "string", // Alt text est optionnel
            "postmeta_title" => "string|nullable" // Title est optionnel
        ]);

        if ($validator->fails()) throw new ValidatorException("Data validation failed", json_encode($validator->errors()));

        // Récupération des métadonnées existantes
        $old_metadata = $attachment->metas()->where('meta_key', '_meta_attachment_metadata')->first();
        $old_file_metadata = $attachment->metas()->where('meta_key', '_meta_attachment_file')->first();

        // Préparation des nouvelles valeurs
        $updated = false;

        // Mise à jour du post_slug si nécessaire
        if ($request->has('post_slug') && $attachment->post_slug != $request->get('post_slug')) {
            $attachment->post_slug = $request->get('post_slug');
            $updated = true;
        }

        // Mise à jour des métadonnées
        $metadata = [
            "alt_text" => $request->get("postmeta_alt", $old_metadata ? unserialize($old_metadata->meta_value)['alt_text'] : null),
            "title" => $request->get("postmeta_title", $old_metadata ? unserialize($old_metadata->meta_value)['title'] : null),
            // Les valeurs de ratio et format sont calculées automatiquement et ne peuvent pas être modifiées par l'utilisateur
            "ratio" => isset($old_metadata) ? unserialize($old_metadata->meta_value)['ratio'] : null,
            "format" => isset($old_metadata) ? unserialize($old_metadata->meta_value)['format'] : null
        ];

        // Mise à jour des métadonnées "_meta_attachment_metadata"
        if ($old_metadata) {
            $old_metadata->meta_value = serialize($metadata);
            $old_metadata->save();
            $updated = true;
        }

        // TODO : Mise à jour de la métadonnée "_meta_attachment_file" si le nom du fichier a changé

        // Si des modifications ont été effectuées, on sauvegarde l'attachement
        if ($updated) {
            $attachment->save();

            return (new PostmetaResource($old_metadata))
                ->success()
                ->setCode(200)
                ->setMessage("Attachment and metadata updated successfully");
        } else {
            return BaseResource::error()
                ->setCode(200)
                ->setMessage("No changes were made")
                ->setErrors(json_encode(["not_modified" => "The attachment is already up to date"]));
        }
    }

    public function destroy($id) {
        // Récupération de l'attachement existant
        $attachment = Attachment::find($id);

        if (!$attachment) throw new NotFoundException("Not found", json_encode(["not_found"=> "The attachment you're trying to delete is not found"]));

        $this->authorize("delete", $attachment);

        $path = ltrim(Storage::url($attachment->metas()->where("meta_key", "_meta_attachment_file")->first()->meta_value), "/");

        if (file_exists($path)) {
            try {
                unlink($path);
            } catch (\Exception $e) {
                return BaseResource::error()
                    ->setCode(500)
                    ->setMessage("Failed to delete the file")
                    ->setErrors(json_encode(["delete_error" => "Failed to delete the file from the server.  Error :\n" . $e ]));
            }
        } else {
            return BaseResource::error()
                ->setCode(500)
                ->setMessage("Failed to delete the file")
                ->setErrors(json_encode(["delete_error" => "File was not found on the server"]));
        }

        // Suppression des métadonnées
        $attachment->metas()->where('meta_key', '_meta_attachment_metadata')->delete();
        $attachment->metas()->where('meta_key', '_meta_attachment_file')->delete();

        // Suppression de l'attachement
        $attachment->delete();

        return BaseResource::error()
            ->success()
            ->setCode(200)
            ->setMessage("Attachment deleted successfully");
    }

}
