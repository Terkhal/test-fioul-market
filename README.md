test-dev
========

Un stagiaire à créer le code contenu dans le fichier src/Controller/Home.php

Celui permet de récupérer des urls via un flux RSS ou un appel à l’API NewsApi. 
Celles ci sont filtrées (si contient une image) et dé doublonnées. 
Enfin, il faut récupérer une image sur chacune de ces pages.

Le lead dev n'est pas très satisfait du résultat, il va falloir améliorer le code.

Pratique : 
1. Revoir complètement la conception du code (découper le code afin de pouvoir ajouter de nouveaux flux simplement) 
Split du controller avec 3 services dédiés., ajout de nouveaux flux via un nouveau service à implémenter. 
Possible de pousser un peu : faire un mapping des services pour que le controller les récupère de façon dynamique ? (je ne sais pas si c'est envisageable.)


Questions théoriques : 
Que mettriez-vous en place afin d'améliorer les temps de réponse du script ?

Solution 1 : Une gestion de cache pour éviter le temps de chargement à l'arrivée sur la page.
Solution 2 : Si l'API elle-même pose des problèmes de durée, possiblement la changer ou faire une requête sur un nombre moins important d'URLs.


Comment aborderiez-vous le fait de rendre scalable le script (plusieurs milliers de sources et images) ?

Comme dit plus haut, je n'ai pas pour habitude d'avoir des temps de réponse aussi longs, cela ne semblait pas venir de chez moi. Donc, j'ignore si le test avait aussi pour but d'optimiser ça. Le flux RSS avait 5 secondes de délai et l'API News environ quinze secondes.
À ma connaissance, je partirais sur un principe de microservices, pour éviter un conflit entre le backend et le frontend. Un système de cache et d'indexation des images, avoir un/des webhooks si les flux sont mis à jour. Ensuite, je pars sur ce que je ne connais pas vraiment : le Load Balancing et l'Auto-Scaling semblent être des solutions possibles.


