<?php
 class Contact {
  function index(){
  	$f3 = Base::instance();
  	/* 
    echo $f3->get('PARAMS.who');
    echo '<br />';
    echo 'hello from contact controller';
    echo $f3->get('PARAMS.0');
    echo $f3->get('PARAMS.1');
    echo $f3->get('PARAMS.2');
    for($i=0 ;$i< 5 ;$i++)
    {
    	$var = 'PARAMS.'.$i;
    	if(null !=$f3->get($var))
    		echo '$$('.$i.')'.$f3->get($var);
    }*/
    echo "Contact PAge";
    echo '<a href="'. $f3->alias('the_contact_page', 'who=avenirer').'">The contact page</a>';
  }



  function qui()
  {
  	$f3 = Base::instance();
    echo $f3->get('PARAMS.who');
  }
  function comment()
  {
  	$f3 = Base::instance();
    echo $f3->get('PARAMS.who').'//'.$f3->get('PARAMS.how');
  }
}
