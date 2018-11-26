<?php
 class Homepage extends Controller 
 {
    private $jours ;
  function __construct()
  {
    $jours ;
    for($i = 1; $i< 25; $i++)
    {
      $jours[$i] = $i;
    }
    $this->setJours($jours);
  }
/*  function auth()
  {
    $auth = new \Auth (string $storage [, array $args = NULL ]);
    $db=new \DB\SQL('mysql:host=localhost;port=8889;dbname=cal00','calUser', 'calUsesrPwd');
    $mapper = new \DB\SQL\Mapper($db, 'participants');
    $auth = new \Auth($mapper, array('id' => 'username', 'pw' => 'password'));
    $auth->login('admin','secret_pwd'); 
  }*/
  function index(){
        $this->set('name', 'MOIIIII');
        $this->set('thisDay', date('j'));
        $this->set('url', $this->alias('the_contact_page','who=avenirer'));
        $this->set('jours', $this->shuffle_assoc($this->jours));
        echo \Template::instance()->render('HomepageView.php','text/html');
  }

  function thisTheDay()
  {
    echo '<pre>';
    var_dump($this);

    $test = new Evenement($this->db);
    $this->set('datas', $test->listBydayAndVictim($this->get('PARAMS.day'), 'Pat'));
    echo \Template::instance()->render('jour.php','text/html');
    echo $this->get('PARAMS.day');
  }

  function setJours(array $tab)
  {
    $this->jours = $tab;
  }
  function getJours()
  {
    return $this->jours;
  }
  function shuffle_assoc($my_array)
  {
        $keys = array_keys($my_array);

        shuffle($keys);

        foreach($keys as $key) {
            $new[$key] = $my_array[$key];
        }

        $my_array = $new;

        return $my_array;
    }

}
