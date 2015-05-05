<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Music extends CI_Model
{
	protected $id = '';
	protected $path = '';
	protected $title = '';
	
	/**
	 *	Ajoute un produit
	 */
	public function ajouter_produits($libelle_produit, $description, $id_gamme, $lien_demo)
	{
		//	Ces données seront automatiquement échappées
		$this->db->set('libelle_produit',   $libelle_produit);
		$this->db->set('description', $description);
		$this->db->set('id_gamme', $id_gamme);
		$this->db->set('id_menu', $id_gamme);
		$this->db->set('lien_demo', $lien_demo);
		
		//	Ces données ne seront pas échappées
		// $this->db->set('date', 'NOW()', false);
		
		//	Une fois que tous les champs ont bien été définis, on "insert" le tout
		$this->db->insert($this->produits);
		
		return $this->db->insert_id();
	}
	
	/**
	 *	Édite une produit déjà existante
	 */
	 
	public function editer_produits($id_produit, $demo = null, $description = null)
	{
		//	Il n'y a rien à éditer
		if($demo == null AND $description == null)
		{
			return false;
		}
		
		//	Ces données seront échappées
		$this->db->set('lien_demo', $demo);
		$this->db->set('description', $description);
		
		//	La condition
		$this->db->where('id_produit', (int) $id_produit);
		
		return $this->db->update($this->produits);
	}
	
	public function editer_produits_fiche_pdf($id_produit, $lien_fiche_image = null, $lien_fiche = null)
	{
		//	Il n'y a rien à éditer
		if($lien_fiche == null AND $lien_fiche_image == null)
		{
			return false;
		}
		
		if($lien_fiche_image != null)
			$this->db->set('lien_fiche_image', $lien_fiche_image);
		else
			$this->db->set('lien_fiche_image', 'defaut.png');
		
		if($lien_fiche != null)
		{
			$this->db->set('lien_fiche', $lien_fiche);
		}
		
		//	La condition
		$this->db->where('id_produit', (int) $id_produit);
		
		return $this->db->update($this->produits);
	}
	
	
	
	/**
	 *	Supprime un produit
	 */
	public function supprimer_produit($id_p)
	{
		return $this->db->where('id_produit', $id_p)
						->delete($this->produits);
	}
	
	/**
	 *	Retourne le nombre de produit
	 */
	public function count()
	{
		
	}
	
	/**
	 *	Retourne une liste de produit
	 */
	public function get_produits()
	{
		return $this->db->query("
								SELECT *
								FROM ".$this->produits ." produits, ".$this->gamme ." produits_gamme
								WHERE produits.id_gamme = produits_gamme.id_gamme
								ORDER BY produits_gamme.libelle_gamme ASC
								");
	}
	/**
	 *	Retourne une liste de gammes
	 */
	public function get_gammes()
	{
		return $this->db->query("
								SELECT * 
								FROM ".$this->gamme ."
								");
	}

	/**
	 *	Retourne un produit
	 */
	public function get_produit($id_produit)
	{
		return $this->db->select('*')
			->from($this->produits)
			->where('id_produit', (int) $id_produit)
			->get()
			->result();
	}
	
	/**
	 *	Ajoute une image à la galerie d'un produit
	 */
	public function ajouter_image_galerie($id_p, $lien_image)
	{
		//	Ces données seront automatiquement échappées
		$this->db->set('id_produit',   $id_p);
		$this->db->set('lien_image',   $lien_image);
		
		//	Une fois que tous les champs ont bien été définis, on "insert" le tout
		return $this->db->insert($this->galerie);
	}
	
	/**
	 *	Retourne les images d'une galerie d'un produit
	 */
	public function get_images_galerie($id_p)
	{
		return $this->db->query("SELECT * 
								FROM ".$this->galerie."
								WHERE id_produit = ".$id_p."
								ORDER BY id_produit");
	}

	/**
	 *	Supprime une image d'une galerie d'un produit
	 */
	public function supprimer_image_galerie($id_p, $lien_image)
	{
		return $this->db->where('id_produit', $id_p)
						->like('lien_image', $lien_image, 'after')
						->delete($this->galerie);
	}
	
}