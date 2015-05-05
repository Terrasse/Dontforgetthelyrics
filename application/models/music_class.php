<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Music_class extends CI_Model
{
	protected $tMusic = 'music';
	
	/**
	 *	Add a music to the db
	 */
	public function add_music($path, $title)
	{
		//	Ces données seront automatiquement échappées
		$this->db->set('title', $title);
		$this->db->set('path', $path);
		
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
	
	public function update_music($id_music, $path = null, $title = null)
	{
		//	Il n'y a rien à éditer
		if($path == null AND $title == null)
		{
			return false;
		}
		
		if($path != null)
			$this->db->set('path', $path);
		
		if($lien_fiche != null)
		{
			$this->db->set('lien_fiche', $lien_fiche);
		}
		
		//	La condition
		$this->db->where('id_produit', (int) $id_produit);
		
		return $this->db->update($this->produits);
	}
	
	/**
	 *	Remove a music from the db
	 */
	public function remove_music($id_music)
	{
		return $this->db->where('id_music', $id_music)
						->delete($this->tMusic);
	}
	
}