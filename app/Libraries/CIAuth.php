<?php
    namespace App\Libraries;
    use App\Models\User;

    class CIAuth
    {
        public static function setCIAuth($result){
            $session = session();
            $array = ['loggend_id'=>true];
            $userdata = $result;
            $session->set('userdata', $userdata);
            $session->set($array);
        }

        public static function id(){
            $session = session();
            if($session->has('loggend_id') ){
                if( $session->has('userdata') ){
                    return $session->get('userdata')['id'];
                }else{
                    return null;
                }
            }else{
                return null;
            }
        }

        public static function check(){
            $session = session();
            return $session->has('loggend_id');
        }

        public static function forget(){
            $session = session();
            $session->remove('loggend_id');
            $session->remove('userdata');
        }

        public static function user(){
            $session = session();
            if( $session->has('userdata') ){
                if( $session->has('userdata') ){
                    // return $session->get('userdata');
                    $user = new User();
                    return $user->asObject()->where('id',CIAuth::id())->first();
                }else{
                    return null;
                }
            }else{
                return null;
            }
        }
    }