<?php
/**
 * Generic Parent Controller of the Sample Site
 * All controllers extend this class
 *
 * PHP version 5
 * 
 * @category PHP
 * @package  Fat-Free-PHP-Bootstrap-Site
 * @author   Mark Takacs <takacsmark@takacsmark.com>
 * @license  MIT 
 * @link     takacsmark.com
 */
 
 /**
 * Parent Controller class
 * 
 * @category PHP
 * @package  Fat-Free-PHP-Bootstrap-Site
 * @author   Mark Takacs <takacsmark@takacsmark.com>
 * @license  MIT 
 * @link     takacsmark.com
 */
class Controller
{
    protected $f3;
    protected $db;

    /**
     * The beforeroute event handler is provided by f3 and it is 
     * automatically invoked by f3 before every time routing happens
     *
     * We check in the below code if there is a user information in the session 
     * i.e. if there is a logged in user 
     *
     * @return void 
     */
    function beforeroute()
    {
        /* on remettra un truc du genre quand on aura une authent*/
        $routeLibre = array('/', '/login', '/google_landing');
//        if($_SESSION['user'] === null && !in_array($this->f3->get('PATH'), $routeLibre)) {
        if($this->f3->get('SESSION.user') === null && !in_array($this->f3->get('PATH'), $routeLibre) and false) {
            $this->f3->reroute('/login');
            exit;
        }
        
    }

    /**
     * The beforeroute event handler is provided by f3 and it is 
     * automatically invoked by f3 after every time routing happens
     *
     * The below code is just a placeholder 
     *
     * @return void 
     */
    function afterroute()
    {
        // your code comes here
    }

    /**
     * Class constructor 
     * We connect to the mysql database here and  
     * Assign value to f3 and db protected class variables defined above
     *
     * @return void 
     */
    function __construct()
    {   
        $f3=Base::instance();
        $this->f3=$f3;

        $db=new DB\SQL(
            $f3->get('devdb'),
            $f3->get('devdbusername'),
            $f3->get('devdbpassword'),
            array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION )
        );
        $this->db=$db;
       // $db = $f3->get('DB');
        // just create an object
//        $session = new \DB\SQL\Session($this->db, 'sessions', true,'CSRF');
//        $this->f3->copy('CSRF','SESSION.csrf');
//        $this->f3->CSRF =$session->csrf();
        new Session();
        if($this->f3->get('PATH') == "/")
            $this->f3->set('SESSION.test',123);
        //echo $f3->get('SESSION.test');
    }


    function affichage()
    {
        $amis = null;
        $uid = null;
echo "... MA SESSION USER<br>";
//        $session = new \DB\SQL\Session($this->db, 'sessions', true,'CSRF');
//        $this->f3->CSRF =$session->csrf();
//        var_dump($this->f3->get('SESSION'));
echo "... FIN ... MA SESSION USER";
        if($this->f3->get('SESSION.user') !== null)
        {
            $amis = $this->f3->get("SESSION.user")->amis ;
            $uid = $this->f3->get("SESSION.user")->uid ;
        }
        $this->f3->set('amis', $amis);
        $this->f3->set('uid', $uid);
        echo \Template::instance()->render('layout.html','text/html');
    }
}