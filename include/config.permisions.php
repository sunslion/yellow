<?php
$menus = array(
    //'distributeds',
    //'servers',
    //'notices',
    'channels',
    'users',
    //'games',
    //'blogs',
    //'albums',
    'videos',
    //'hd',
    'picture',
    //'novel',
    'avActor',
    'admin',
    'index',
);
$sub_menus = array(
    'index' => array(
        'main', 'check', 'mail', 'modules', 'static', 'media', 'iphone', 'flv', 'mp4', 
        'permissions', 'sessions', 'bandwidth','bans', 
        'emails', 'emailadd', 'emailedit', 'advgroups', 'advs', 'advadd', 'advgroupedit', 
        'advedit','advmedia', 'advtext', 'advmediaadd', 'advtextadd', 'advtextedit', 
        'advmediaedit', 
        'player', 'playeradd', 'playeredit','new_player', 'userpermisions', 'new_advs', 
        'new_advsedit', 'new_advsadd', 'advzone', 'advzoneadd', 'advzoneedit','adv_count',
        'cache', 'mfile'
    ),
    'admin' => array(
        'all','add','edit',
    ),
    'novel' => array(
        'list','add','edit','del'
    ),
    'hd' => array(
        
    ),
    'videos' => array(
        'all', 'public', 'private', 'flagged', 'view', 'edit', 'add', 'spam', 'grabber', 'embed'
    ),
    'albums' => array(
        'all', 'public', 'private', 'view', 'edit', 'add','addphoto', 'viewphoto', 'editphoto', 'spam', 'flagged'
    ),
    'blogs' => array(
        'all','spam'
    ),
    'games' => array(
        'all','public','private','flagged','spam','add'
    ),
    'users' => array(
        'all','guests','spread', 'active', 'inactive', 'edit', 'view', 'mail','mailall', 'flagged', 'spam', 'commentedit', 'comments', 'add','deposit','deposit_add','deposit_edit','getgame'
    ),
    'channels' => array(
        'list','listgame','add','addgame'
    ),
    'notices' => array(
        'list', 'add', 'edit', 'add_image', 'list_images', 'view', 'delete', 'list_categories'
    ),
    'servers' => array(
        'all', 'add', 'edit'
    ),
    'distributeds' => array(
        'distributeds_all', 'distributeds_add', 'distributeds_edit','distributed_all', 'distributed_add', 'distributed_edit','distributed_config','help'
    ),
);

$sub_menus_action = array(
    'admin'=>array(
      'all'=>array(
          'delete','suspend','activate'
      )
    ),
    'users'=>array(
        'all'=>array(
            'delete','suspend','approve','delete_multiple','suspend_multiple','approve_multiple','addsebi','send_email'
        ),
        'active' => array(
            'delete','suspend','approve','delete_multiple','suspend_multiple','approve_multiple','addsebi','send_email'
        ),
        'inactive' => array(
            'delete','suspend','approve','delete_multiple','suspend_multiple','approve_multiple','addsebi','send_email'
        ),
        'deposit' => array('delete'),
        'getgame' => array('check_guname'),
    ),
    'videos' => array(
        'all' => array(
            'delete','suspend','activate','regenthumbs','duration','delete_multiple','suspend_multiple','approve_multiple','tuijian'
        ),
        'public' => array(
            'delete','suspend','activate','regenthumbs','duration','delete_multiple','suspend_multiple','approve_multiple','tuijian'
        ),
        'private' => array(
            'delete','suspend','activate','regenthumbs','duration','delete_multiple','suspend_multiple','approve_multiple','tuijian'
        )
    ),

);
