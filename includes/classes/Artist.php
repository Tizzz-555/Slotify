<?php 
	class Artist {
		private $con;  // Private property to store the database connection
		private $id;   // Private property to store the artist ID

		public function __construct($con, $id) {
			$this->con = $con;   // Assigning the passed database connection to the private property
			$this->id = $id;     // Assigning the passed artist ID to the private property
		}

		public function getName() {
			$artistQuery = mysqli_query($this->con, "SELECT name FROM artists WHERE id = '$this->id'"); 
			// Query the database using the passed artist ID to retrieve the artist's name from the 'artists' table
			
			$artist = mysqli_fetch_array($artistQuery);
			// Fetch the result of the query as an associative array
			
			return $artist['name'];
			// Return the value of the 'name' column from the fetched result
		}
	}
?>
