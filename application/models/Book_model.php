<?php

/**
* 
*/
class Book_model extends CI_Model
{
	var $table = 'buku';

	//untuk insert ke dalam database
	public function tambah_data($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function get_all_books(){
		$this->db->from('buku');
		$query = $this->db->get();
		return $query->result();

	}

	public function get_by_id($id){
		$this->db->from($this->table);
		$this->db->where('id_buku', $id);
		$query = $this->db->get();

		return $query->row();
	}
	
	public function update_data($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id_buku', $id);
		$this->db->delete($this->table);
	}
}
?>