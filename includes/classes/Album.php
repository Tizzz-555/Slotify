<?php 
	class Album {
		private $con;           // Private property to store the database connection
		private $id;            // Private property to store the album ID
		private $title;         // Private property to store the album title
		private $artistId;      // Private property to store the artist ID associated with the album
		private $genre;         // Private property to store the album genre
		private $artworkPath;   // Private property to store the artwork path for the album

		public function __construct($con, $id) {
			$this->con = $con;   // Assigning the passed database connection to the private property
			$this->id = $id;     // Assigning the passed album ID to the private property

			$albumQuery = mysqli_query($this->con, "SELECT * FROM Albums WHERE id = '$this->id'");
			// Query the database using the passed album ID to retrieve all album information from the 'Albums' table
			$album = mysqli_fetch_array($albumQuery);
			// Fetch the result of the query as an associative array

			$this->title = $album['title'];               // Assign the 'title' column value from the fetched result to the private property
			$this->artistId = $album['artist'];           // Assign the 'artist' column value from the fetched result to the private property
			$this->genre = $album['genre'];               // Assign the 'genre' column value from the fetched result to the private property
			$this->artworkPath = $album['artworkPath'];   // Assign the 'artworkPath' column value from the fetched result to the private property
		}

		public function getTitle() { 
			return $this->title;   // Return the value of the private 'title' property
		}

		public function getArtworkPath() { 
			return $this->artworkPath;   // Return the value of the private 'artworkPath' property
		}

		public function getArtist() { 
			return new Artist($this->con, $this->artistId);   // Create and return a new Artist object using the private 'artistId' property and the passed database connection
		}

		public function getGenre() { 
			return $this->genre;   // Return the value of the private 'genre' property
		}

		public function getNumberOfSongs() {
			$query = mysqli_query($this->con, "SELECT * FROM Songs WHERE album ='$this->id'");
			// Query the database using the private 'id' property to retrieve all songs associated with the album
			return mysqli_num_rows($query);   // Return the number of rows (songs) in the result set
		}

		public function getSongIds() {
			$query = mysqli_query($this->con, "SELECT id FROM Songs WHERE album='$this->id' ORDER BY albumORDER ASC");
			// Query the database using the private 'id' property to retrieve the IDs of all songs associated with the album, ordered by 'albumORDER' column

			$array = array();   // Create an empty array

			while ($row = mysqli_fetch_array($query)) {
				array_push($array, $row['id']);   // Add each song ID to the array
			}

			return $array;   // Return the array of song IDs
		}
	}
?>
