# tmpMA20 - Updated Framework - Singleton (pseudo) for Database - Multiple Layout

* For using new layout for subController... exemple admin/ please add this in application/config/library.php :

    `$config['layouts'] = ['admin'=>'LayoutAdmin'];`

* Create new LayoutAdminView.phtml in folder application/www/


# Documentation

## La classe Http

* Upload de fichier exemple pour un champs input `picture`
    ` /** Image uploadée
            *   On la déplace sinon on affecte à NULL pour la saisie en base
            */
            if ($http->hasUploadedFile('picture'))
                $picture = $http->moveUploadedFile('picture','/uploads/categories');
            else 
                $picture = NULL;`
                
* Redirection vers une autre page :
    `/** Redirection vers la liste des catégories */
     $http->redirectTo('admin/categories/');
