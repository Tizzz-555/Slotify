<?php 
	class Song {
    private $con;           
		private $id;            
		private $mysqliData;    
		private $title;         
		private $artistId;      
		private $albumId;       
		private $genre;         
		private $duration;      
		private $path;          

 		public function __construct($con, $id) {
 			$this->con = $con;   // Assigning the passed database connection to the private property
 			$this->id = $id;     // Assigning the passed song ID to the private property

 			$query = mysqli_query($this->con, "SELECT * FROM Songs WHERE id='$this->id'");
			// Query the database using the passed song ID to retrieve all song information from the 'Songs' table
      $this->mysqliData = mysqli_fetch_array($query);
			// Fetch the result of the query as an associative array

			$this->title = $this->mysqliData['title'];             // Assign the 'title' column value from the fetched result to the private property
			$this->artistId = $this->mysqliData['artist'];         // Assign the 'artist' column value from the fetched result to the private property
			$this->albumId = $this->mysqliData['album'];           // Assign the 'album' column value from the fetched result to the private property
			$this->genre = $this->mysqliData['genre'];             // Assign the 'genre' column value from the fetched result to the private property
			$this->duration = $this->mysqliData['duration'];       // Assign the 'duration' column value from the fetched result to the private property
			$this->path = $this->mysqliData['path'];               // Assign the 'path' column value from the fetched result to the private property
 		}

    public function getTitle() { 
      return $this->title;   // Return the value of the private 'title' property
    }

    public function getArtist() { 
      return new Artist($this->con, $this->artistId);   // Create and return a new Artist object using the private 'artistId' property and the passed database connection
    }

    public function getAlbum() { 
      return new Album($this->con, $this->albumId);   // Create and return a new Album object using the private 'albumId' property and the passed database connection
    }

    public function getPath() { 
      return $this->path;   // Return the value of the private 'path' property
    }

    public function getGenre() { 
      return $this->genre;   // Return the value of the private 'genre' property
    }

    public function getDuration() { 
      return $this->duration;   // Return the value of the private 'duration' property
    }
     
    public function getMysqliData() { 
      return $this->mysqliData;   // Return the entire fetched data array
    }

    public function getId() { 
      return $this->id;
    }
  }