<?php
	//require_once '../models/common/Helpers.php';
	
    class Db implements db_interface{

        protected static $connection;

        /**
         * Connect to the database
         * 
         * @return bool false on failure / mysqli MySQLi object instance on success
         */
        public function connect() {    

            if(!isset(self::$connection)) {

                $config = parse_ini_file('C:/config/config.ini'); 
                self::$connection = new mysqli($config['host'],$config['username'],$config['password'],$config['dbname']);
            }

						
            if(self::$connection === false) {
            		die('Unable to connect to database');
                return false;
            }
            
            return self::$connection;
        }

        /**
         * Query the database
         *
         * @param $query The query string
         * @return mixed The result of the mysqli::query() function
         */
        public function query($query) {

            $connection = $this -> connect();

            $result = $connection -> query($query);

            return $result;
        }

        /**
         * Fetch rows from the database (SELECT query)
         *
         * @param $query The query string
         * @return bool False on failure / array Database rows on success
         */
        public function select($query) {
            $rows = array();
            $result = $this -> query($query);
            if($result === false) {
                return false;
            }
            while ($row = $result -> fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        }

        public function insert($query) {
            $connection = $this -> connect();
            $connection -> query($query);
            $result = $connection -> insert_id;
            return $result;
        } 
        
        /**
         * Fetch the last error from the database
         * 
         * @return string Database error message
         */
        public function error() {
            $connection = $this -> connect();
            return $connection -> error;
        }

        /**
         * Quote and escape value for use in a database query
         *
         * @param string $value The value to be quoted and escaped
         * @return string The quoted and escaped string
         */
        public function quote($value) {
            $connection = $this -> connect();
            return "'" . $connection -> real_escape_string($value) . "'";
        }

			  public function quoteOrNull($val)
			  {
					if (empty($val))
			    {
			    	return ("NULL");
					}
					else
					{
						return ($this-> quote($val));
					}
				}
				
				public function numberOrNull($val)
			  {
					if ( empty($val) or !is_numeric($val))
			    {
			    	return ("NULL");
					}
					else
					{
						return ($val);
					}
				}

    }
