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
1. Que mettriez-vous en place afin d'améliorer les temps de réponses du script

solution 1: A defaut d'avoir essayer: une gestion de cache pour éviter le temps de chargement en arrivant sur la page.
solution 2: Je ne sais pas si c'est l'api elle-même qui pose des souci de durée, possiblement la changer / faire une reuête sur un nombre moins important d'url.


2. Comment aborderiez-vous le fait de rendre scalable le script (plusieurs milliers de sources et images)
 
Comme dit plus haut je n'ai pas pour habitude d'avoir des temps de réponse aussi long, ça ne semblait pas venir de chez moi. donc j'ingore si le test avait aussi pour but d'optimiser ça.
le flux RSS avait 5 second de délai et le news api une quinzaine de seconde.
   
 A ma connaissance, je partirai sur un principe de micro service, pour éviter un conflit entre load back / front.
  un système de cache et d'indexation des images, avoir un / des webhooks si les feed sont mis à jour ?
  et la je pars dans ce que je ne connais pas vraiment : Load Balancing et Auto-Scaling semblent des possibles solutions. 




