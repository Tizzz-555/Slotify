<?php
  class Playlist {

    private $con;
    private $id;
    private $name;
    private $owner;

    public function __construct($con, $data) {

      if(!is_array($data)) {
        // Data is an id string
        $query = mysqli_query($con, "SELECT * FROM playlists WHERE id='$data'");
        $data = mysqli_fetch_array($query);
      }
      $this->con = $con;
      $this->id = $data['id'];
      $this->name = $data['name'];
      $this->owner = $data['owner'];
    }
    
    public function getId() {
      return $this->id;
    }

    public function getName() {
      return $this->name;
    }

    public function getOwner() {
      return $this->owner;
    }

    public function getNumberOfSongs() {
      $query = mysqli_query($this->con, "SELECT songId FROM playlistSongs WHERE playlistId='$this->id'");
      return mysqli_num_rows($query);
    }

    public function getSongIds() {
			$query = mysqli_query($this->con, "SELECT songId FROM playlistSongs WHERE playlistId='$this->id' ORDER BY playlistOrder ASC");
			// Query the database using the private 'id' property to retrieve the IDs of all songs associated with the album, ordered by 'albumORDER' column

			$array = array();   // Create an empty array

			while ($row = mysqli_fetch_array($query)) {
				array_push($array, $row['songId']);   // Add each song ID to the array
			}

			return $array;   // Return the array of song IDs
		}

    public static function getPlaylistsDropdown($con, $username) {
      $dropdown = '<select class="item playlist">
                    <option value="">Add to playlist</option>
                  </select>';
      return $dropdown;
    }
}
?>