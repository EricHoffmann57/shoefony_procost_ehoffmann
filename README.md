# symfony_procost_ehoffmann

Eric Hoffmann hoffma183u@etu.univ-lorraine.fr

# fixtures

Elles ont été testées dans le projet pour valider sa structure avec succès. Sur le dashboard, les valeurs de départ de la rentabilité et du taux de livraison sera logiquement à zéro puisqu'aucun projet n'a de date de livraison actée. Les graphiques sont updatés en temps réel !

Après avoir longuement testé les différentes fonctionnalités, je n'ai pas trouvé de bug empéchant le fonctionnement de l'application, à part quelques lenteurs parfois au niveau de la base de données avec un rafraichissement pas toujours en temps réel que je me suis efforcé de corriger.

Les erreurs 404 ont été gérées avec un "throw exception" puisque les templates twig de la documentation Symfony ne sont utilisables qu'en mode production, fait confirmé sur stack overflow. 
A priori il n'y a aucune erreur 500 visible.

# Remarque
Le calcul de rentabilité sur le dashboard est un vrai calcul mathématique du ratio prix de vente/coût de production, il sera donc légèrement différent d'un ratio basé uniquement sur le nombre de projets.
En effet si deux projets sont vendus, si un seul est bénéficiaire, le ratio théorique afficherait 50% de succès et pourtant ce n'est pas la réalité économique! 
Un projet vendu avec une forte marge compense la perte et à l'inverse un produit peu bénéficiaire peut faire descendre le ratio sous la barre des 50%...
