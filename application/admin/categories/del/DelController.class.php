<?php

class DelController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {

        $id = $queryFields['id'];

        $categoryModel = new CategoriesModel();
        
        /** Suppression de la photo attachée à la catégorie */
        $picture = $categoryModel->find($id);
        $image = $picture['cat_picture'];
        if($image != NULL && file_exists(WWW_PATH.'/uploads/categories/'.$image)){
            unlink(WWW_PATH.'/uploads/categories/'.$image);
        }

        /** Suppression d'une catégorie dans la base */
        $categorie = $categoryModel->delete($id);
        
        
        /**  Création du flashbag */
        $flashbag = new Flashbag();
        $flashbag->add('La catégorie a bien été supprimée');
        
        /** Redirige vers la liste des catégories */
        $http->redirectTo('admin/categories/');

    }

    public function httpPostMethod(Http $http, array $formFields)
    {
        /** Rien ici on ne bient pas sur cette page en POST */
    }

}