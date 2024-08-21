# bloc1
# heading text{#identifier cssselector}

[__Sources__](https://developer.mozilla.org/fr/docs/Web/HTTP/Methods)

<h1><ins>1 - Méthodes GET et POST</ins></h1>


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

<h1><ins>2 – Comparaison méthodes</ins></h1>

<table>
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">GET</th>
      <th scope="col">POST</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">La requête a un corps</th>
      <th scope="row">:x:</th>
      <td>:heavy_check_mark:</td>
    </tr>
    <tr>
      <th scope="row">Une réponse de succès a un corps</th>
      <th scope="row">:heavy_check_mark:</th>
      <td>:heavy_check_mark:</td>
    </tr>
    <tr>
      <th scope="row">Sûre</th>
      <th scope="row">:heavy_check_mark:</th>
      <td>:x:</td>
    </tr>
    <tr>
      <th scope="row">Idempotente</th>
      <th scope="row">:heavy_check_mark:</th>
      <td>:x:</td>
    </tr>
    <tr><th scope="row">Peut être mise en cache</th>
      <th scope="row">:heavy_check_mark:</th>
      <td>:heavy_check_mark:*</td>
    </tr>
    <tr>
      <th scope="row">Autorisée dans les formulaires HTML</th>
      <th scope="row">:heavy_check_mark:</th>
      <td>:heavy_check_mark:</td>
    </tr>
</table>

<p>*Seulement si une information de péremption est incluse</p>

<h1><ins>3 -Extensible</ins></h1>

- Sa syntaxe est dite « extensible » car elle permet de définir différents langages avec pour chacun son vocabulaire et sa grammaire.

<h1><ins>4 - Sans état</ins></h1>

- Lorsqu’on dit que HTTP est un protocole sans état, cela signifie que HTTP n’a pas besoin que le serveur conserve des informations sur un client entre deux requêtes. Autrement dit, chaque nouvelle requête peut agir de manière totalement indépendante et n’a pas de lien à priori avec les requêtes précédentes ou suivantes.

Par exemple, deux des principes de base du HTTP sont qu’une requête ne peut récupérer qu’une seule ressource à la fois / n’effectuer qu’une action à la fois et que HTTP est un protocole sans état. 

<h1><ins>5 – URL</ins></h1>

<a href="https://shadps4.net/](https://www.spreadfamily.fr/glossaire/url"><img src="https://github.com/shadps4-emu/shadPS4/blob/main/.github/shadps4.png](https://cdn.prod.website-files.com/5eeb8b290ae25bce2125fc54/642fca11a8fb4d068243263a_url-definition.webp" width="220"></a>
