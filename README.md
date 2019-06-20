
# tmpMA20 - Updated Framework - Singleton (pseudo) for Database - Multiple Layout

* For using new layout for subController... exemple admin/ please add this in application/config/library.php :

    `$config['layouts'] = ['admin'=>'LayoutAdmin'];`

* Create new LayoutAdminView.phtml in folder application/www/


# Documentation
## Créer un contrôleur
Dans le dossier `application/controllers/` il vous suffit de créer une classe Controller. Par exemple pour créer un contrôleur qui va afficher une liste de produits que l'on va nommer `ListeArticle` il faudra créer un fichier `ListeArticleController.class.php` dans le répertoire `application/controllers/listearticle/`
Dans ce fichier il faudra créer une classe `ListeArticleController` qui contiendra 2 méthodes :

 - public  function  httpGetMethod(Http  $http,  array  $queryFields)
 - public  function  httpPostMethod(Http  $http,  array  $formFields)

La première sera appelée en cas de requête GET vers le contrôleur et bien sûr la deuxième en cas de requête POST vers le contrôleur.
Exemple complet :

    class  ListeArticleController
    {
    
	    public  function  httpGetMethod(Http  $http,  array  $queryFields)
	    {
		    /*
		    * Méthode appelée en cas de requête HTTP GET
		    *
		    * L'argument $http est un objet permettant de faire des redirections etc.
		    * L'argument $queryFields contient l'équivalent de $_GET en PHP natif.
		    */
	    }
	    public  function  httpPostMethod(Http  $http,  array  $formFields)
	    {
    
		    /*
		    * Méthode appelée en cas de requête HTTP POST
		    *
		    * L'argument $http est un objet permettant de faire des redirections etc.
		    * L'argument $formFields contient l'équivalent de $_POST en PHP natif.
		    */
    
	    }
    }

## Créer un modèle
Dans le dossier `application/models/` il vous suffit de créer une classe Model. Par exemple pour créer un modèle qui va gérer le modèle de données pour les articles `Catégorie` il faudra créer un fichier `CatégorieModel.class.php` dans le répertoire `application/models/`

Les méthodes de cet objet sont à votre convenance mais il semble nécessaire d'y placer les actions conventionnels d'un CRUD.
Exemple complet :

    <?php
    class CategoriesModel {
	    /**
	     * @var Database Objet Database pour effectuer des requête
	     */
	    private $dbh;

	    /**
	     * @var string Database table utilisée pour les requête
	     */
	    private $table;

	    /**  Constructeur
	     *
	     * @param void
	     * @return void
	     */
	    public function __construct()
	    {
	        $this->dbh = new Database();
	        $this->table = 'category';
	    }

	    /** Retourne un tableau de toutes les catégories en base
	     *
	     * @param void
	     * @return Array Jeu d'enregistrement représentant toutes les catégories en base
	     */
	    public function listAll() 
	    {
	        return $this->dbh->query('SELECT * FROM '.$this->table);
	    }

	    /** Ajoute une catégorie en base
	     *
	     * @param string $name nom de la catégorie
	     * @param string $description description de la cétégorie
	     * @param string $picture nom de l'image
	     */
	    public function add($name, $description, $picture) 
	    {
	        return $this->dbh->executeSQL('INSERT INTO '.$this->table.' (cat_name, cat_description,cat_picture) VALUES (?,?,?)',[$name, $description, $picture]);
	    }

	    /** Trouve une catégorie avec son ID
	     *
	     * @param integer $id identifiant de la catégorie
	     * @return Array Jeu d'enregistrement comportant la catégorie trouvée
	     */
	    public function find($id)
	    {
	        return $this->dbh->queryOne('SELECT * FROM '.$this->table.' WHERE cat_id = ?',[$id]);
	    }

	   
	    /** Modifie une catégorie en base
	     *
	     * @param integer $id identifiant de la catégorie
	     * @param interger $id nom de la catégorie
	     * @param string $name nom de la catégorie
	     * @param string $description description de la cétégorie
	     * @param string $picture nom de l'image
	     * @return void
	     */
	    public function update($id, $name, $description, $picture)
	    {
	        $this->dbh->executeSQL('UPDATE '.$this->table.' SET cat_name=?, cat_description=? ,cat_picture =? WHERE cat_id=?',[$name, $description, $picture, $id]); 
	    }

	    /** Supprime une catégorie avec son ID
	     *
	     * @param integer $id identifiant de la catégorie
	     * @return void
	     */
	    public function delete($id)
	    {
	        $this->dbh->executeSQL('DELETE FROM '.$this->table.' WHERE cat_id=?',[$id]);
	    }
	}

Exemple d'appel d'un modèle dans le contrôleur :

    $categorie = new CategorieModel();
    $categorie->add('titre','description','url/image');

## Transmettre des données à la vue
Il suffit de retourner un tableau association à partir du contrôleur pour que chaque index du tableau devienne une variable pour la vue. Ces variables contiennent respectivement la valeur associé dans le tableau.
Exemple :

    return ["title"=>'Titre de la page',
    'articles'=>$jeuEnregistrement];

Dans la vue il sera donc possible d'appeler les variables `$title` et `$articles`

L'utilisation d'un index `_form` ou `_raw_template` dans le tableau retourné par le contrôleur va induire une attente du framework. Dans le premier cas la valeur transmise devra être un objet instance de la class Form, dans le deuxième cas le framework attend un booléen. Si `true`la vue sera chargée sans le layout.  

## La classe Http

* **Upload de fichier** exemple pour un champs input `picture`
    ` /** Image uploadée
            *   On la déplace sinon on affecte à NULL pour la saisie en base
            */
            if ($http->hasUploadedFile('picture'))
                $picture = $http->moveUploadedFile('picture','/uploads/categories');
            else 
                $picture = NULL;`
                
* **Redirection** vers une autre page en fournissant une route du framework :
    `/** Redirection vers la liste des catégories */
     $http->redirectTo('admin/categories/');
