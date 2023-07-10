<?php 
	class Artist {
		private $con;  // Private property to store the database connection
		private $id;   // Private property to store the artist ID

		public function __construct($con, $id) {
			$this->con = $con;   // Assigning the passed database connection to the private property
			$this->id = $id;     // Assigning the passed artist ID to the private property
		}

		public function getId() {
			return $this->id;
		}
		
		public function getName() {
			$artistQuery = mysqli_query($this->con, "SELECT name FROM artists WHERE id = '$this->id'"); 
			// Query the database using the passed artist ID to retrieve the artist's name from the 'artists' table
			
			$artist = mysqli_fetch_array($artistQuery);
			// Fetch the result of the query as an associative array
			
			return $artist['name'];
			// Return the value of the 'name' column from the fetched result
		}

		public function getSongIds() {
			$query = mysqli_query($this->con, "SELECT id FROM songs WHERE artist='$this->id' ORDER BY plays ASC");

			$array = array();

			while($row = mysqli_fetch_array($query)) {
				array_push($array, $row['id']);
			}

			return $array;
		}
	}
?>
