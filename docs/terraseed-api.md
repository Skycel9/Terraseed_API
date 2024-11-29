# Terraseed API

> <h3 style="color: salmon">⚠️ Ouvrir dans un interpréteur Markdown pour une meilleure expérience de lecture ⚠️</h3>


## Introduction
Cette API a pour but d'être utilisé pour la création d'une webapp mobile utilisant Angular. L'objectif est de réussir à créer un API puissante comme pourrait le nécessité des gros projets WEB.

L'évolution envisagé pour cette API est de gérér un usage hors cadre scolaire, en développant le projet. C'est pourquoi, le rigourosité est important à ce stade de développement et certaine fonctionnalité ne sont pas encore fini.L'usage de l'API est pour l'instant privé, pour répondre au besoin de notre web application. Mais à pour vocation de s'ouvrir afin d'être utilisé par le grand public dans d'autre système.

> ⚠️ Le développement logique de l'API est assez complexe due aux choix fait, cependant le développement uniquement basé sur les notions sur les cours et selon moi pas suffisemment intéressant. C'est pourquoi, je préfère développer grandement l'API.

Le développement est encore en cours, et sera dans une version publiable sur internet en même temps que l'application web, courant **Janvier** !

##  Ressources
|                                                                                          ![Image](resources/img/logo-figma.webp)                                                                                           |                                                                          ![Image](resources/img/logo-drawio.png)                                                                           |                                                                    ![Image](resources/img/logo-gogs.png)                                                                    |
|:--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------:|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------:|:---------------------------------------------------------------------------------------------------------------------------------------------------------------------------:|
| [Maquette figma](https://www.figma.com/design/eUGDlY2Xpy8hsr4s0638i5/SAE-501-WEBAPP?node-id=0-1&t=3rm8kY68uaur2jzK-1)<br>[<img src="resources/img/dl.png" width="32" height="32">](resources/files/maquette-terraseed.fig) | [MPD](https://drive.google.com/file/d/1p1GxVBOslDyBLDXRUyj6ISBJ0935y6ao/view?usp=sharing)<br>[<img src="resources/img/dl.png" width="32" height="32">](resources/files/MPD-Terraseed.webp) | [Gogs](https://git.araneite.dev/) \| [Github](https://github.com/Skycel9/Terraseed_API)<br><p style="color: gray;">Github utilisé uniquement pour la mise en production</p> |

|    |    |    |                                          ![Image](resources/img/logo-postman.png)                                          |    |    |    | ![Image](resources/img/logo-internet.webp) |    |    |    |
|----|----|----|:------------------------------------------------------------------------------------------------------------------------:|----|----|----|:------------------------------------------:|----|----|----|
|    |    |    | Maquette figma<br>[<img src="resources/img/dl.png" width="32" height="32">](resources/files/terraseed-api-requests.json) |    |    |    |           [Lien API distante]()            |    |    |    |


> Pour consulter la dernière version de l'API
> Rendez-vous sur [git.araneite.dev](https://git.araneite.dev/Etudes/Terraseed_API.git)
> 
> Il vous faudra vous connecter, voici les identifiants :
> 
> | Identifiant  |           Mot de passe            |
> |:------------:|:---------------------------------:|
> |   teachers   | kX^4gL3WnF$eq"Z4RVi"3,'F,^YJC,x9  |


# API Documentation

## 📁 Folder: Posts

### End-point: /api/posts

#### GET /api/posts - Récupère la liste des posts

Récupère la liste des publications

#### Response

```json
{
    "data": {
        "list": [
            {
                "id": 1,
                "title": "Thgsdjfd",
                "slug": "thgsdjfd",
                "description": "Tesd",
                "content": "Papyrus",
                "coordinates": {
                    "lat": "35.704126571862915",
                    "long": "139.55773706422423"
                },
                "type": "post",
                "parent": 1,
                "author": {
                    "id": 1,
                    "displayName": "Skycel"
                },
                "created_at": null,
                "updated_at": "2024-11-14T13:23:02.000000Z"
            },
            {
                "id": 3,
                "title": "Restes de plats ?",
                "slug": "3-restes-de-plats",
                "description": "Il a pas fini son assiette ?",
                "content": "\"J'ai découverts des débris de graine et un tout petit tas de graines sur mon balcons, je suppose que mon hôte a du partir en vitesse sans finir son assiette, mais qui est-il ?\"",
                "coordinates": {
                    "lat": "60.44982096068672",
                    "long": "22.276881726016295"
                },
                "type": "post",
                "parent": null,
                "author": {
                    "id": 2,
                    "displayName": "Koda"
                },
                "created_at": null,
                "updated_at": null
            }, [...]
        ],
        "meta": {
            "total": 7
        }
    },
    "success": true,
    "code": 200,
    "message": "Post list loaded successfully"
}

```

#### Method: GET

> ```
> {{base_url}}/api/posts/
> ```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: /api/posts/ {id}

#### GET /api/posts/ {id} - Récupère un post

Récupère les informations à propos d'une publication, filtré par son ID

#### Response

```json
{
    "data": {
        "id": 39,
        "title": "Test1",
        "slug": "test1",
        "description": "Publication de test",
        "content": "<h1 class='preserveHtml' class='preserveHtml' class='preserveHtml' class='preserveHtml' class='preserveHtml' class='preserveHtml' class='preserveHtml' class='preserveHtml' class='preserveHtml' class='preserveHtml'>Hello world!</h1>",
        "coordinates": {
            "lat": "9.5808",
            "long": "176.7344"
        },
        "type": "post",
        "parent": null,
        "author": {
            "id": 1,
            "displayName": "Skycel"
        },
        "created_at": "2024-11-23T01:06:23.000000Z",
        "updated_at": "2024-11-23T01:06:23.000000Z"
    },
    "success": true,
    "code": 200,
    "message": "Post retrieved successfully"
}

```

#### Method: GET

> ```
> {{base_url}}/api/posts/39
> ```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: /api/posts

#### POST /api/posts - Créer une publication

Permet de créer une nouvelle publication

#### Request Body - _urlencoded_

- `post_coordinates_lat` (text): Coordonnées de latitude de la publication.
- `post_coordinates_long` (text): Coordonnées de longitude de la publication.
- `post_content` (text): Contenu de la publication.
- `post_description` (text): Courte description de la publication.
- `post_author` (text): ID de l'auteur de la publication.
- `post_title`(text): Titre de la publication.

#### Response

```json
{
    "data": {
        "id": 39,
        "title": "Test1",
        "slug": "test1",
        "description": "Publication de test",
        "content": "<h1 class='preserveHtml' class='preserveHtml' class='preserveHtml' class='preserveHtml' class='preserveHtml' class='preserveHtml' class='preserveHtml' class='preserveHtml' class='preserveHtml' class='preserveHtml'>Hello world!</h1>",
        "coordinates": {
            "lat": "9.5808",
            "long": "176.7344"
        },
        "type": "post",
        "parent": null,
        "author": {
            "id": 1,
            "displayName": "Skycel"
        },
        "created_at": "2024-11-23T01:06:23.000000Z",
        "updated_at": "2024-11-23T01:06:23.000000Z"
    },
    "success": true,
    "code": 201,
    "message": "Post created successfully"
}

```

#### Method: POST

> ```
> {{base_url}}/api/posts/
> ```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: /api/posts/ {id}

#### PUT /api/posts/ {ID}

Cet endpoint, sert à la modification d'une publication

#### Request Body - _urlencoded_

- `post_title` (text) -Nouveau titre de la publication.
- `post_description` (text) - La nouvelle description de la publication.
- `post_content` (text) - Le nouveau contenu de la publication.

`Soon...` - D'autre possibilité de modification sont en cours de développement

#### Response

```json
{
    "data": {
        "list": {
            "old": {
                "id": 1,
                "title": "Thgsdjfd",
                "slug": "thgsdjfd",
                "description": "Tesd",
                "content": "Hello",
                "coordinates": {
                    "lat": "35.704126571862915",
                    "long": "139.55773706422423"
                },
                "type": "post",
                "parent": 1,
                "author": {
                    "id": 1,
                    "displayName": "Skycel"
                },
                "created_at": null,
                "updated_at": "2024-11-23T01:11:52.000000Z"
            },
            "new": {
                "id": 1,
                "title": "Bonjour",
                "slug": "bonjour",
                "description": "Tesd",
                "content": "Hello",
                "coordinates": {
                    "lat": "35.704126571862915",
                    "long": "139.55773706422423"
                },
                "type": "post",
                "parent": 1,
                "author": {
                    "id": 1,
                    "displayName": "Skycel"
                },
                "created_at": null,
                "updated_at": "2024-11-23T01:12:01.000000Z"
            }
        },
        "meta": {
            "total": 2
        }
    },
    "success": true,
    "code": 200,
    "message": "Post updated successfully"
}

```

#### Method: PUT

> ```
> {{base_url}}/api/posts/{{ID}}
> ```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: /api/posts {id}

#### DELETE /api/posts/ {id} - Supprimer une publication

Permet de supprimer un poste en fonction de son ID.

#### Response

```json
{
    "data": [],
    "success": true,
    "code": 200,
    "message": "Post (39) `Test1` deleted successfully"
}

```

#### Method: DELETE

> ```
> {{base_url}}/api/posts/39
> ```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: /api/topics/ {id}/posts

#### GET /api/topics/ {id}/posts

Permet de récupéré la liste des publication associé a un topic, défini par l'ID

#### Response

```json
{
    "data": {
        "list": [
            {
                "id": 1,
                "title": "Bonjour",
                "slug": "bonjour",
                "description": "Tesd",
                "content": "Hello",
                "coordinates": {
                    "lat": "35.704126571862915",
                    "long": "139.55773706422423"
                },
                "type": "post",
                "parent": 1,
                "author": {
                    "id": 1,
                    "displayName": "Skycel"
                },
                "created_at": null,
                "updated_at": "2024-11-23T01:12:01.000000Z"
            },
            {
                "id": 13,
                "title": "Celian est le goat qu'il pense être même s'il est un peu bizarre",
                "slug": "celian-est-le-goat-quil-pense-etre-meme-s-il-est-un-peu-bizarre",
                "description": "",
                "content": "<h1 class='preserveHtml' class='preserveHtml' class='preserveHtml'>Kayako BEME</h1>",
                "coordinates": {
                    "lat": "85.9469",
                    "long": "-67.7060"
                },
                "type": "post",
                "parent": 1,
                "author": {
                    "id": 1,
                    "displayName": "Skycel"
                },
                "created_at": "2024-11-14T13:21:22.000000Z",
                "updated_at": "2024-11-14T13:24:10.000000Z"
            }
        ],
        "meta": {
            "total": 2
        }
    },
    "success": true,
    "code": 200,
    "message": "Posts for this topic retrieved successfully"
}

```

#### Method: GET

> ```
> {{base_url}}/api/topics/1/posts
> ```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

# 📁 Folder: Comments

### End-point: /api/posts/ {id}/comments

#### GET /api/posts/ {id}/comments- Récupère la liste des commentaire d'une publication

Récupère la liste des publications associé aux commentaire défini par l'ID

#### Response

```json
{
    "data": {
        "list": [
            {
                "id": 2,
                "author": {
                    "id": 2,
                    "displayName": "Koda"
                },
                "content": "\"C'est les traces d'un chien je pense, c'est assez commun. Mais féliciation de l'avoir vu quand même ! \"",
                "type": "comment",
                "parent": {
                    "id": 1,
                    "title": "Bonjour",
                    "slug": "bonjour",
                    "description": "Tesd",
                    "content": "Hello",
                    "coordinates": {
                        "lat": "35.704126571862915",
                        "long": "139.55773706422423"
                    },
                    "type": "post",
                    "parent": 1,
                    "author": {
                        "id": 1,
                        "displayName": "Skycel"
                    },
                    "created_at": null,
                    "updated_at": "2024-11-23T01:12:01.000000Z"
                }
            }
        ],
        "meta": {
            "total": 1
        }
    },
    "success": true,
    "code": 200,
    "message": "Comment list loaded successfully"
}

```

#### Method: GET

> ```
> {{base_url}}/api/posts/1/comments/
> ```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: /api/comments/ {id}

StartFragment

#### GET /api/comments/ {id}- Récupère un commentaire

Récupère le commentaire dont l'ID est défini dans l'URL

#### Response

```json
{
    "data": {
        "id": 2,
        "author": {
            "id": 2,
            "displayName": "Koda"
        },
        "content": "\"C'est les traces d'un chien je pense, c'est assez commun. Mais féliciation de l'avoir vu quand même ! \"",
        "type": "comment",
        "parent": {
            "id": 1,
            "title": "Bonjour",
            "slug": "bonjour",
            "description": "Tesd",
            "content": "Hello",
            "coordinates": {
                "lat": "35.704126571862915",
                "long": "139.55773706422423"
            },
            "type": "post",
            "parent": 1,
            "author": {
                "id": 1,
                "displayName": "Skycel"
            },
            "created_at": null,
            "updated_at": "2024-11-23T01:12:01.000000Z"
        }
    },
    "success": true,
    "code": 200,
    "message": "Comment retrieved successfully"
}

```

#### Method: GET

> ```
> {{base_url}}/api/comments/2
> ```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: /api/post/ {id}/comments

#### POST /api/posts/ {id}/comments- Publier un commentaire associé a une publication

Permet d'ajouter un commentaire à une publication

#### Request Body - _urlencoded_

- `comment_content`(text): Message du commentaire.
- `comment_author` (text): ID de l'auteur du commentraire.

#### Response

```json
{
    "data": {
        "id": 40,
        "author": {
            "id": 1,
            "displayName": "Skycel"
        },
        "content": "Je suis un nouveau commentaire",
        "type": "comment",
        "parent": 3
    },
    "success": true,
    "code": 201,
    "message": "Comment created successfully"
}

```

#### Method: POST

> ```
> {{base_url}}/api/posts/3/comments
> ```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: /api/comments/ {id}

#### DELETE /api/comments/ {id} - Supprimer un commentaire

Permet de supprimer un commentaire en fonction de son ID.

#### Response

```json
{
    "data": [],
    "success": true,
    "code": 200,
    "message": "Post (39) `Test1` deleted successfully"
}

```

#### Method: DELETE

> ```
> {{base_url}}/api/comments/14
> ```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## 📁 Folder: Topics

### End-point: /api/topics

#### GET /api/topics- Récupère la liste des topics

Récupère la liste des publications

#### Response

```json
{
    "data": {
        "list": [
            {
                "id": 1,
                "title": "Empreintes",
                "slug": "empreintes",
                "banner": 4,
                "icon": null,
                "author": {
                    "id": 1,
                    "displayName": "Skycel"
                },
                "created_at": null,
                "updated_at": null
            },
            {
                "id": 2,
                "title": "Alimentations",
                "slug": "alimentations",
                "banner": null,
                "icon": 4,
                "author": {
                    "id": 1,
                    "displayName": "Skycel"
                },
                "created_at": null,
                "updated_at": null
            },...
        "meta": {
            "total": 4
        }
    },
    "success": true,
    "code": 200,
    "message": "Topic list loaded successfully"
}

```

#### Method: GET

> ```
> {{base_url}}/api/topics
> ```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: /api/topics/ {id}

#### GET /api/posts/ {id} - Récupère un commentaire

Récupère les informations à propos d'un commentaire, filtré par son ID

#### Response

```json
{
    "data": {
        "id": 2,
        "title": "Alimentations",
        "slug": "alimentations",
        "banner": null,
        "icon": 4,
        "author": {
            "id": 1,
            "displayName": "Skycel"
        },
        "created_at": null,
        "updated_at": null
    },
    "success": true,
    "code": 200,
    "message": "Topic retrieved successfully"
}

```

#### Method: GET

> ```
> {{base_url}}/api/topics/2
> ```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: /api/topics

#### POST /api/topics- Créer un topic

Permet de créer une nouveau topic

#### Request Body - _urlencoded_

- `topic_title` (text): Nom du topic.
- `topic_slug` (text): Slug unique du topic (basé sur le nom du topic).
- `topic_banner` (text): ID de l'attachment qui est utilisé comme bannière du topic.
- `topic_icon` (text): ID de l'attachment qui est utilisé comme bannière du topic.
- `topic_author` (text): ID de l'auteur de la publication.

#### Response

```json
{
    "data": {
        "id": 5,
        "title": "Testons",
        "slug": "testons",
        "banner": "4",
        "icon": "3",
        "author": {
            "id": 2,
            "displayName": "Koda"
        },
        "created_at": "2024-11-23T01:40:58.000000Z",
        "updated_at": "2024-11-23T01:40:58.000000Z"
    },
    "success": true,
    "code": 201,
    "message": "Topic created successfully"
}

```

#### Method: POST

> ```
> {{base_url}}/api/topics
> ```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: /api/topics/ {id}

#### PUT /api/topics/ {ID}

Cet endpoint, sert à la modification d'un topic.

#### Request Body - _Query Params_

- `topic_title` - Nouveau titre de la publication.

`Soon...` - D'autre possibilité de modification sont en cours de développement

#### Response

```json
{
    "data": {
        "list": {
            "old": {
                "id": 4,
                "title": "test",
                "slug": "dejections",
                "banner": null,
                "icon": null,
                "author": {
                    "id": 2,
                    "displayName": "Koda"
                },
                "created_at": "2024-11-20T01:47:52.000000Z",
                "updated_at": "2024-11-20T02:12:16.000000Z"
            },
            "new": {
                "id": 4,
                "title": "Déjections",
                "slug": "dejections",
                "banner": null,
                "icon": null,
                "author": {
                    "id": 2,
                    "displayName": "Koda"
                },
                "created_at": "2024-11-20T01:47:52.000000Z",
                "updated_at": "2024-11-20T02:12:16.000000Z"
            }
        },
        "meta": {
            "total": 2
        }
    },
    "success": true,
    "code": 200,
    "message": "Topic updated successfully"
}

```

#### Method: PUT

> ```
> {{base_url}}/api/topics/4?topic_title=Déjections
> ```

#### Query Params


| Param       | value       |
| ----------- | ----------- |
| topic_title | Déjections |

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: /api/topics/ {id}

#### DELETE /api/topics/ {id} - Supprimer un topic

Permet de supprimer un topic en fonction de son ID.

#### Response

```json
{
    "data": [],
    "success": true,
    "code": 200,
    "message": "Topic (4) `Déjections` deleted successfully"
}

```

#### Method: DELETE

> ```
> {{base_url}}/api/topics/5
> ```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## 📁 Folder: Attachments

### End-point: /api/attachments

#### GET /api/attachments- Récupère la liste des attachments

Récupère la liste des attachments

#### Response

```json
{
    "data": {
        "list": [
            {
                "id": 4,
                "author": {
                    "id": 1,
                    "displayName": "Skycel"
                },
                "title": "image-3",
                "type": "attachment",
                "slug": "image-3.jpg",
                "parent": null,
                "meta": [
                    {
                        "id": null,
                        "post_id": 4,
                        "meta_key": "_meta_attachment_metadata",
                        "meta_value": {
                            "alt_text": "Photo d'une trace de pattes dans de la\nterre",
                            "ratio": "null",
                            "format": "jpg",
                            "title": "Empreintes de pattes"
                        }
                    },
                    {
                        "id": null,
                        "post_id": 4,
                        "meta_key": "_meta_attachment_file",
                        "meta_value": "/media/img/image-3.jpg"
                    }
                ]
            }
        ],
        "meta": {
            "total": 1
        }
    },
    "success": true,
    "code": 200,
    "message": "Attachment list loaded successfully"
}

```

#### Method: GET

> ```
> {{base_url}}/api/attachments/
> ```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: /api/attachments/ {id}

#### GET /api/attachments/ {id} - Récupère un attachment

Récupère les informations à propos d'un attachment, filtré par son ID

#### Response

```json
{
    "data": {
        "id": 4,
        "author": {
            "id": 1,
            "displayName": "Skycel"
        },
        "title": "image-3",
        "type": "attachment",
        "slug": "image-3.jpg",
        "parent": null,
        "meta": [
            {
                "id": null,
                "post_id": 4,
                "meta_key": "_meta_attachment_metadata",
                "meta_value": {
                    "alt_text": "Photo d'une trace de pattes dans de la\nterre",
                    "ratio": "null",
                    "format": "jpg",
                    "title": "Empreintes de pattes"
                }
            },
            {
                "id": null,
                "post_id": 4,
                "meta_key": "_meta_attachment_file",
                "meta_value": "/media/img/image-3.jpg"
            }
        ]
    },
    "success": true,
    "code": 200,
    "message": "Attachment retrieved successfully"
}

```

#### Method: GET

> ```
> {{base_url}}/api/attachments/4
> ```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: /api/attachments

#### POST /api/attachments - Créer un attachment

Permet de mettre en ligne un fichier

#### Request Body - form-data

- `post_slug` (text): Identifiant unique textuel nommant le fichier.
- `attachment_file` (file): Fichier publié qui sera stocké sur le serveur
- `post_author` (text): ID de l'auteur de la publication.
- `postmeta_alt`(text): Texte alternati du fichier.

#### Response

```json
{
    "data": {
        "id": 41,
        "author": {
            "id": 1,
            "displayName": "Skycel"
        },
        "title": null,
        "type": "attachment",
        "slug": "emprunte-1-Noy2fu0vR11mqqL4ZaHgpyRctuBBLiWTEY9b5GQm.webp",
        "parent": null,
        "meta": [
            {
                "id": null,
                "post_id": 41,
                "meta_key": "_meta_attachment_metadata",
                "meta_value": {
                    "alt_text": "Image généré par IA",
                    "title": null,
                    "ratio": "7:4",
                    "format": "webp"
                }
            },
            {
                "id": null,
                "post_id": 41,
                "meta_key": "_meta_attachment_file",
                "meta_value": "uploads/emprunte-1-Noy2fu0vR11mqqL4ZaHgpyRctuBBLiWTEY9b5GQm.webp"
            }
        ]
    },
    "success": true,
    "code": 201,
    "message": "Attachment upload successfully"
}

```

#### Method: POST

> ```
> {{base_url}}/api/attachments/
> ```

#### Body formdata


| Param           | value                                                 | Type |
| --------------- | ----------------------------------------------------- | ---- |
| post_slug       | emprunte-1.jpg                                        | text |
| attachment_file | postman-cloud:///1efa7872-bf40-4290-ab19-4c34a46a9ecd | file |
| post_author     | 1                                                     | text |
| postmeta_alt    | Image généré par IA                                | text |

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: /api/attachments/ {id}

#### PUT /api/attachments/ {ID}

Cet endpoint, sert à la modification d'un attachment

#### Request Body - _Query Params_

- `postmeta_alt` (text) -Nouveau titre de la publication.

`Soon...` - D'autre possibilité de modification sont en cours de développement

#### Response

```json
{
    "data": {
        "id": null,
        "post_id": 41,
        "meta_key": "_meta_attachment_metadata",
        "meta_value": {
            "alt_text": "Test",
            "title": null,
            "ratio": "7:4",
            "format": "webp"
        }
    },
    "success": true,
    "code": 200,
    "message": "Attachment and metadata updated successfully"
}

```

#### Method: PUT

> ```
> {{base_url}}/api/attachments/41?postmeta_alt=Test
> ```

#### Query Params


| Param        | value |
| ------------ | ----- |
| postmeta_alt | Test  |

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: /api/attachments/ {id}

#### DELETE /api/attachments/ {id} - Supprimer un attachment

Permet de supprimer un attachment en fonction de son ID.

#### Response

```json
{
    "data": [],
    "success": true,
    "code": 200,
    "message": "Attachment deleted successfully"
}

```

#### Method: DELETE

> ```
> {{base_url}}/api/attachments/42
> ```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## 📁 Folder: User

### End-point: /api/register

#### POST /api/register - Inscrire un utilisateur

Permet a un utilisateur de s'inscrire.

#### Request Body - _form-data_

- `user_email` (text) - L'email de l'utilisateur.
- `password` (text) - Mot de passe de l'utilisateur.
- `name` (text) - Le login de l'utilisateur.

`Soon...` - D'autre champs pour l'inscription sont en cours de développement

#### Response

```json
{
    "data": {
        "id": 5,
        "displayName": null
    },
    "success": true,
    "code": 201,
    "message": "User registered successfully"
}

```

#### Method: POST

> ```
> {{base_url}}/api/register
> ```

#### Body formdata


| Param      | value              | Type |
| ---------- | ------------------ | ---- |
| user_email | celian@araneite.co | text |
| password   | test               | text |
| name       | gloopss            | text |

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: /api/login

#### POST /api/login - Inscrire un utilisateur

Permet a un utilisateur de s'inscrire.

#### Request Body - _form-data_

- `email` (text) - L'email de l'utilisateur.
- `password` (text) - Mot de passe de l'utilisateur.

`Soon...` - D'autre champs pour l'inscription sont en cours de développement

#### Response

```json
{
    "data": {
        "id": 4,
        "displayName": null,
        "contact": {
            "email": "celian@example.com",
            "phone": {
                "extension": null,
                "number": null
            }
        },
        "created_at": "2024-11-22 01:35:24",
        "updated_at": "2024-11-22 01:35:24"
    },
    "success": true,
    "code": 200,
    "message": "Login successful",
    "token": "12|BEARER_TOKEN"
}

```

#### Method: POST

> ```
> {{base_url}}/api/login
> ```

#### Body formdata


| Param    | value               | Type |
| -------- | ------------------- | ---- |
| email    | celian@araneite.com | text |
| password | test                | text |

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: /api/me

#### GET /api/me - Information sur l'utilisateur connecté

Permet de récupéré les informations sur l'utilisateur connecté.

#### Headers

- `Authorization` - Bearer token give after login

### Response

```json
{
    "data": {
        "id": 2,
        "displayName": "Koda",
        "contact": {
            "email": "koda@example.com",
            "phone": {
                "extension": 33,
                "number": 123456789
            }
        },
        "created_at": null,
        "updated_at": null,
        "profile": {
            "firstName": "Malo",
            "lastName": "Houbre",
            "gender": "male",
            "birthday": "2002-11-15"
        },
        "email_verified_at": null
    },
    "success": true,
    "code": 200,
    "message": "User information retrieved successfully"
}

```

#### Method: GET

> ```
> {{base_url}}/api/me
> ```

#### Headers


| Content-Type  | Value     |
| ------------- | --------- |
| Authorization | Bearer 10 |

#### Body formdata


| Param | value | Type |
| ----- | ----- | ---- |

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: /api/profile/ {id}

#### GET /api/profile/ {id} - Information sur un l'utilisateur

Permet de récupéré les informations sur un utilisateur, défini par l'ID.

#### Headers

- `Authorization` - Bearer token give after login

### Response

Response can change depend of your app permissions

> As ANY PERMISSION

```json
{
    "data": {
        "id": 2,
        "displayName": "Koda",
    },
    "success": true,
    "code": 200,
    "message": "User profile retrieved successfully"
}

```

> As USER PERMISSION

```json
{
    "data": {
        "id": 2,
        "displayName": "Koda",
        "contact": {
            "email": "koda@example.com",
            "phone": {
                "extension": 33,
                "number": 123456789
            }
        },
        "created_at": null,
        "updated_at": null
    },
    "success": true,
    "code": 200,
    "message": "User profile retrieved successfully"
}

```

> As SUPERADMIN PERMISSION

```json
{
    "data": {
        "id": 2,
        "displayName": "Koda",
        "contact": {
            "email": "koda@example.com",
            "phone": {
                "extension": 33,
                "number": 123456789
            }
        },
        "created_at": null,
        "updated_at": null,
        "profile": {
            "firstName": "Malo",
            "lastName": "Houbre",
            "gender": "male",
            "birthday": "2002-11-15"
        },
        "email_verified_at": null
    },
    "success": true,
    "code": 200,
    "message": "User profile retrieved successfully"
}

```

#### Method: GET

> ```
> {{base_url}}/api/profile/2
> ```

#### Headers


| Content-Type  | Value     |
| ------------- | --------- |
| Authorization | Bearer 10 |

### Headers


| Content-Type  | Value     |
| ------------- | --------- |
| Authorization | Bearer 11 |

### Body formdata


| Param      | value               | Type |
| ---------- | ------------------- | ---- |
| user_email | celian@araneite.com | text |
| password   | test                | text |

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃
