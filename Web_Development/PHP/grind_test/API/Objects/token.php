<?php
/*
    Script for creating or checkin tokens
*/

    // JSON Web Token
    include "../Config/core.php";
    include "../Libraries/php-jwt-master/src/BeforeValidException.php";
    include "../Libraries/php-jwt-master/src/ExpiredException.php";
    include "../Libraries/php-jwt-master/src/SignatureInvalidException.php";
    include "../Libraries/php-jwt-master/src/JWT.php";
    use \Firebase\JWT\JWT;

    class Token {

        private $exp;
        private $key;

        function __construct() {

            $this->exp = (time() + 24 * 60 * 60);
            $this->key = "super_secret_key";
        }
        
        function createToken($studentID) {

            // Create token's payload
            $tokenPayload = array(
                "exp" => $this->exp,
                "data" => array(
                    "UserID" => $studentID
                )
            );

            // Create JWT
            $token = JWT::encode($tokenPayload, $this->key);

            return $token;
        }

        function decodeToken($encodedToken) {
            
            $token = JWT::decode($encodedToken, $this->key, array("HS256"));

            return $token;
        }
    }
?>