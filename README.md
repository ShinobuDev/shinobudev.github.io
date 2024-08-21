# bloc1

<h1>1 - Méthodes GET et POST</h1>

__Source__ : https://developer.mozilla.org/fr/docs/Web/HTTP/Methods

<h2>Méthode GET :</h2>

- La méthode GET demande une représentation de la ressource spécifiée. Les requêtes GET doivent uniquement être utilisées afin de récupérer des données.

GET /index.html

<h2>Méthode POST :</h2>

- La méthode POST est utilisée pour envoyer une entité vers la ressource indiquée. Cela entraîne généralement un changement d'état ou des effets de bord sur le serveur.

<html>
POST / HTTP/1.1
Host: foo.com
Content-Type: application/x-www-form-urlencoded
Content-Length: 13

say=Hi&to=Mom
</html>

<h1>2 – Comparaison méthodes</h1>
