# Backend för Moment 3 - Fördjupad frontend-utveckling
#### Av Kajsa Classon, HT24. DT193G - Fullstack-utveckling med ramverk, Mittuniversitetet.

En REST-webbtjänst för en bloggplattform. 
Webbtjänsten har full CRUD-funktionalitet för att hantera inlägg och sköter även registrering av användare samt in- och utloggning.

Webbtjänsten är skapad med hjälp av ramverket Laravel och använder middlewaren Sanctum för autentisering.

Repo för klient-applikationen hittar du här:

Klientapplikationen finns även publicerad på: 

## Uppgiftsbeskrivning
Uppgiften går ut på att skapa en Single Page Application med React med implementerad routing och autentisering. Till exempel en personlig bloggplattform där användare kan hantera blogginlägg, eller ett enkelt lagerhanteringssystem för produkthantering. 

Projektet ska bestå av:
* Ett backend-API
* Frontend skapad som en Single Page Application med React och TypeScript

### Krav på API
* Autentisering med JWT-tokens
* Login-endpoint som returnerar JWT-token (antingen direkt i responsen eller som HTTP-cookie).
* Validering av token för skyddade endpoints
* CRUD-operationer för ditt innehåll (blogginlägg/produkter)
    * GET för att hämta alla items och enskilda items
    * POST för att skapa nya items
    * PUT för att uppdatera befintliga items
    * DELETE för att ta bort items

APIet kan skapas i valfritt språk och använda valfri DBMS.

## Användning
Webbtjänsten finns publicerad på: 

### Routes
#### Publika routes
| Metod         | Ändpunkt                     | Beskrivning   |
| ------------- | -------------------------    | ------------- |
| POST          | /api/login                   | Loggar in en användare [^1] |
| POST          | /api/register                | Registrerar en användare [^2] |

[^1] Kräver att ett user-objekt skickas med. (Endast email och password)

[^2] Kräver att ett user-objekt skickas med.

Ett user-objekt skickas som JSON med följande struktur:

``` 
{
    "name": "Test Testsson",
    "email": "test@epost.se",
    "password": "lösenord"
}
```

#### Privata routes
| Metod         | Ändpunkt                       | Beskrivning   |
| ------------- | -------------------------      | ------------- |
| GET           | /api/posts                     | Hämtar alla inlägg |
| POST          | /api/logout                    | Loggar ut inloggad användare |
| ------------- | -------------------------      | ------------- |
| GET           | /api/posts                     | Hämtar alla inlägg |
| GET           | /api/posts/{id}                | Hämtar inlägg med angivet ID |
| POST          | /api/posts                     | Skapar ett nytt inlägg [^3] |
| POST          | /api/posts/{id}?_method=PUT    | Uppdaterar ett inlägg med angivet ID [^4] |
| PUT           | /api/posts/{id}                | Uppdaterar ett inlägg med angivet ID [^5] |
| DELETE        | /api/posts/{id}                | Raderar ett inlägg med angivet ID |

[^3] Kräver att ett post-objekt skickas med som formdata (om bildfil ska skickas) eller JSON.
[^4] Kräver att ett post-objekt skickas med som formdata (om bildfil ska skickas) eller JSON. (Sätter manuellt metoden till PUT) 
[^5] Kräver att ett post-objekt skickas med som JSON-data (OBS! Kan ej uppdatera bild då formdata ej kan hantera metoden PUT i PHP)

Ett post-objekt skickas som formulär- eller JSON-data med följande struktur:

``` 
{
    "title": "Inläggets titel",
    "content": "Innehåll för blogginlägget.",
    "category": "Stickning",
    "user_id": 1,
    "image": "null | file upload"
}
```