<?php
    class HitCounter {
        public $hits;
        public $host;
        public $username;
        public $password;
        public $dbname;
        public $dbConnect;

        function __construct($host, $username, $password, $dbname) {
            $this->host = $host;
            $this->username = $username;
            $this->password = $password;
            $this->dbname = $dbname;

            // Connect to the database
            $this->dbConnect = new mysqli($this->host, $this->username, $this->password, $this->dbname) or die('Failed to connect to server');
        }
        
        function getHits() {
            // Fetch hits from the database
            $result = $this->dbConnect->query("SELECT hits FROM hitcounter WHERE id = 1");
            $row = $result->fetch_assoc();
            $this->hits = $row['hits'];
            return $this->hits;
        }
        
        function setHits($hits) {
            // Update hits in the database
            $this->dbConnect->query("UPDATE hitcounter SET hits = $hits WHERE id = 1");
            $this->hits = $hits;
        }

        function closeConnection() {
            // Close the database connection
            $this->dbConnect->close();
        }

        function startOver() {
            // Set hits to zero in the database
            $this->dbConnect->query("UPDATE hitcounter SET hits = 0 WHERE id = 1");
            $this->hits = 0;
        }
    }
?>