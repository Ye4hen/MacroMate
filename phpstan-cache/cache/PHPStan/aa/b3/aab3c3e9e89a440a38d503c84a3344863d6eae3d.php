<?php declare(strict_types = 1);

// odsl-C:\Users\Yevhen\Desktop\programming_lessons\PHP\Laravel\calories_tracker\app
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v1',
   'data' => 
  array (
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Contracts\\ActivityRepositoryInterface.php' => 
    array (
      0 => '8c52c47b1aef7b001c9d78dd68f572b67af3c90d',
      1 => 
      array (
        0 => 'app\\contracts\\activityrepositoryinterface',
      ),
      2 => 
      array (
        0 => 'app\\contracts\\all',
        1 => 'app\\contracts\\getcachedactivities',
        2 => 'app\\contracts\\paginate',
        3 => 'app\\contracts\\create',
        4 => 'app\\contracts\\update',
        5 => 'app\\contracts\\delete',
        6 => 'app\\contracts\\restore',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Contracts\\FoodRepositoryInterface.php' => 
    array (
      0 => 'c8da8257de9f44ed291ad3d5bb0c7a526f93e4fa',
      1 => 
      array (
        0 => 'app\\contracts\\foodrepositoryinterface',
      ),
      2 => 
      array (
        0 => 'app\\contracts\\all',
        1 => 'app\\contracts\\getcachedfoodsforthelist',
        2 => 'app\\contracts\\paginate',
        3 => 'app\\contracts\\create',
        4 => 'app\\contracts\\update',
        5 => 'app\\contracts\\delete',
        6 => 'app\\contracts\\restore',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Contracts\\MealRepositoryInterface.php' => 
    array (
      0 => 'aecdede6a8d11e11f25171017d012943aba10bbc',
      1 => 
      array (
        0 => 'app\\contracts\\mealrepositoryinterface',
      ),
      2 => 
      array (
        0 => 'app\\contracts\\all',
        1 => 'app\\contracts\\paginate',
        2 => 'app\\contracts\\create',
        3 => 'app\\contracts\\update',
        4 => 'app\\contracts\\delete',
        5 => 'app\\contracts\\restore',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Contracts\\PlanRepositoryInterface.php' => 
    array (
      0 => '9550468f876c6b56c510822c07b6de6554250438',
      1 => 
      array (
        0 => 'app\\contracts\\planrepositoryinterface',
      ),
      2 => 
      array (
        0 => 'app\\contracts\\all',
        1 => 'app\\contracts\\create',
        2 => 'app\\contracts\\update',
        3 => 'app\\contracts\\delete',
        4 => 'app\\contracts\\restore',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Contracts\\UserRepositoryInterface.php' => 
    array (
      0 => '43fe462ce8d0b24d29a0ff44134f182d85cf4170',
      1 => 
      array (
        0 => 'app\\contracts\\userrepositoryinterface',
      ),
      2 => 
      array (
        0 => 'app\\contracts\\findbyemail',
        1 => 'app\\contracts\\all',
        2 => 'app\\contracts\\paginate',
        3 => 'app\\contracts\\filterbyrolecode',
        4 => 'app\\contracts\\create',
        5 => 'app\\contracts\\update',
        6 => 'app\\contracts\\delete',
        7 => 'app\\contracts\\restore',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Contracts\\UserRoleRepositoryInterface.php' => 
    array (
      0 => 'ebe7ef4d760cb89dc78be45a1c06faafba0e8c5c',
      1 => 
      array (
        0 => 'app\\contracts\\userrolerepositoryinterface',
      ),
      2 => 
      array (
        0 => 'app\\contracts\\all',
        1 => 'app\\contracts\\create',
        2 => 'app\\contracts\\update',
        3 => 'app\\contracts\\delete',
        4 => 'app\\contracts\\restore',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Domain\\Models\\Activity.php' => 
    array (
      0 => '77b10f583cc5996614bd9cb102df99e12e18222c',
      1 => 
      array (
        0 => 'app\\domain\\models\\activity',
      ),
      2 => 
      array (
        0 => 'app\\domain\\models\\getroutekeyname',
        1 => 'app\\domain\\models\\plans',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Domain\\Models\\Food.php' => 
    array (
      0 => '70204ec93b886dcf19da3c5239588760424ca9b0',
      1 => 
      array (
        0 => 'app\\domain\\models\\food',
      ),
      2 => 
      array (
        0 => 'app\\domain\\models\\getimageurlattribute',
        1 => 'app\\domain\\models\\getimagevarianturl',
        2 => 'app\\domain\\models\\getroutekeyname',
        3 => 'app\\domain\\models\\isdrink',
        4 => 'app\\domain\\models\\recommendedforplan',
        5 => 'app\\domain\\models\\creator',
        6 => 'app\\domain\\models\\updater',
        7 => 'app\\domain\\models\\meals',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Domain\\Models\\Meal.php' => 
    array (
      0 => '7b9233b7ce10f6f0ff97ac71580b7dd4ad6dd657',
      1 => 
      array (
        0 => 'app\\domain\\models\\meal',
      ),
      2 => 
      array (
        0 => 'app\\domain\\models\\getroutekeyname',
        1 => 'app\\domain\\models\\creator',
        2 => 'app\\domain\\models\\gettype',
        3 => 'app\\domain\\models\\foods',
        4 => 'app\\domain\\models\\nutrients',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Domain\\Models\\Plan.php' => 
    array (
      0 => '2df72c63a4c4f4cadec15f17f722e4ede2003abb',
      1 => 
      array (
        0 => 'app\\domain\\models\\plan',
      ),
      2 => 
      array (
        0 => 'app\\domain\\models\\getroutekeyname',
        1 => 'app\\domain\\models\\activities',
        2 => 'app\\domain\\models\\users',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Domain\\Models\\User.php' => 
    array (
      0 => 'fe032f3d661c9ad38d6fb0c44c7d13629040aaf2',
      1 => 
      array (
        0 => 'app\\domain\\models\\user',
      ),
      2 => 
      array (
        0 => 'app\\domain\\models\\getroutekeyname',
        1 => 'app\\domain\\models\\getusercode',
        2 => 'app\\domain\\models\\getauthpassword',
        3 => 'app\\domain\\models\\getjwtidentifier',
        4 => 'app\\domain\\models\\getjwtcustomclaims',
        5 => 'app\\domain\\models\\isadmin',
        6 => 'app\\domain\\models\\issubadmin',
        7 => 'app\\domain\\models\\ispremium',
        8 => 'app\\domain\\models\\isplainuser',
        9 => 'app\\domain\\models\\role',
        10 => 'app\\domain\\models\\plan',
        11 => 'app\\domain\\models\\activities',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Domain\\Models\\UserActivity.php' => 
    array (
      0 => '3222d4f9aab34a9f05676b97a92a773ee5cd95f0',
      1 => 
      array (
        0 => 'app\\domain\\models\\useractivity',
      ),
      2 => 
      array (
        0 => 'app\\domain\\models\\user',
        1 => 'app\\domain\\models\\activity',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Domain\\Models\\UserRole.php' => 
    array (
      0 => 'ce469f5c25426e547a7ee8117c88e619bf33efaa',
      1 => 
      array (
        0 => 'app\\domain\\models\\userrole',
      ),
      2 => 
      array (
        0 => 'app\\domain\\models\\getroutekeyname',
        1 => 'app\\domain\\models\\users',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Domain\\Repositories\\ActivityRepository.php' => 
    array (
      0 => 'e9551c01a6e70e460d6e6b49373bed15a4b83141',
      1 => 
      array (
        0 => 'app\\domain\\repositories\\activityrepository',
      ),
      2 => 
      array (
        0 => 'app\\domain\\repositories\\__construct',
        1 => 'app\\domain\\repositories\\all',
        2 => 'app\\domain\\repositories\\getcachedactivities',
        3 => 'app\\domain\\repositories\\paginate',
        4 => 'app\\domain\\repositories\\create',
        5 => 'app\\domain\\repositories\\update',
        6 => 'app\\domain\\repositories\\delete',
        7 => 'app\\domain\\repositories\\restore',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Domain\\Repositories\\FoodRepository.php' => 
    array (
      0 => 'eccf46f708c01f365d87418b7b87e4fbe42568e1',
      1 => 
      array (
        0 => 'app\\domain\\repositories\\foodrepository',
      ),
      2 => 
      array (
        0 => 'app\\domain\\repositories\\__construct',
        1 => 'app\\domain\\repositories\\all',
        2 => 'app\\domain\\repositories\\getcachedfoodsforthelist',
        3 => 'app\\domain\\repositories\\paginate',
        4 => 'app\\domain\\repositories\\create',
        5 => 'app\\domain\\repositories\\update',
        6 => 'app\\domain\\repositories\\delete',
        7 => 'app\\domain\\repositories\\restore',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Domain\\Repositories\\MealRepository.php' => 
    array (
      0 => 'c8bd25ad2ae6bcf7855d8ce2003fb1de141a6d55',
      1 => 
      array (
        0 => 'app\\domain\\repositories\\mealrepository',
      ),
      2 => 
      array (
        0 => 'app\\domain\\repositories\\__construct',
        1 => 'app\\domain\\repositories\\all',
        2 => 'app\\domain\\repositories\\paginate',
        3 => 'app\\domain\\repositories\\create',
        4 => 'app\\domain\\repositories\\update',
        5 => 'app\\domain\\repositories\\delete',
        6 => 'app\\domain\\repositories\\restore',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Domain\\Repositories\\PlanRepository.php' => 
    array (
      0 => '49b217d5cda8347d6371490f45e75fcb83e958ee',
      1 => 
      array (
        0 => 'app\\domain\\repositories\\planrepository',
      ),
      2 => 
      array (
        0 => 'app\\domain\\repositories\\__construct',
        1 => 'app\\domain\\repositories\\all',
        2 => 'app\\domain\\repositories\\create',
        3 => 'app\\domain\\repositories\\update',
        4 => 'app\\domain\\repositories\\delete',
        5 => 'app\\domain\\repositories\\restore',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Domain\\Repositories\\UserRepository.php' => 
    array (
      0 => '147962baa70cd0eed526a52a1ba97d5f0b0b34dd',
      1 => 
      array (
        0 => 'app\\domain\\repositories\\userrepository',
      ),
      2 => 
      array (
        0 => 'app\\domain\\repositories\\__construct',
        1 => 'app\\domain\\repositories\\findbyemail',
        2 => 'app\\domain\\repositories\\all',
        3 => 'app\\domain\\repositories\\paginate',
        4 => 'app\\domain\\repositories\\filterbyrolecode',
        5 => 'app\\domain\\repositories\\create',
        6 => 'app\\domain\\repositories\\update',
        7 => 'app\\domain\\repositories\\delete',
        8 => 'app\\domain\\repositories\\restore',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Domain\\Repositories\\UserRoleRepository.php' => 
    array (
      0 => '0c65752fae605d42dc89748c2286ca20fbaacf5d',
      1 => 
      array (
        0 => 'app\\domain\\repositories\\userrolerepository',
      ),
      2 => 
      array (
        0 => 'app\\domain\\repositories\\all',
        1 => 'app\\domain\\repositories\\create',
        2 => 'app\\domain\\repositories\\update',
        3 => 'app\\domain\\repositories\\delete',
        4 => 'app\\domain\\repositories\\restore',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Domain\\Services\\AuthService.php' => 
    array (
      0 => 'ffd9daf2fb74f4dc09a137a0b16c0378767493f9',
      1 => 
      array (
        0 => 'app\\domain\\services\\authservice',
      ),
      2 => 
      array (
        0 => 'app\\domain\\services\\__construct',
        1 => 'app\\domain\\services\\register',
        2 => 'app\\domain\\services\\login',
        3 => 'app\\domain\\services\\logout',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Domain\\Services\\CodeGenerator.php' => 
    array (
      0 => '7b54ad68a2f22f83cb292f8ca479bfcdc70f7036',
      1 => 
      array (
        0 => 'app\\domain\\services\\codegenerator',
      ),
      2 => 
      array (
        0 => 'app\\domain\\services\\generatecode',
        1 => 'app\\domain\\services\\base62encode',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Domain\\Services\\MacrosService.php' => 
    array (
      0 => '3a2abfee18e327247933244b08372306e2337b11',
      1 => 
      array (
        0 => 'app\\domain\\services\\macrosservice',
      ),
      2 => 
      array (
        0 => 'app\\domain\\services\\calculatedailymacrosforuser',
        1 => 'app\\domain\\services\\computeproteinsmaxpercent',
        2 => 'app\\domain\\services\\validatepercentagesstrict',
        3 => 'app\\domain\\services\\validatepercentagesorthrow',
        4 => 'app\\domain\\services\\derivegramsfrompercentages',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Domain\\Services\\StatsService.php' => 
    array (
      0 => '1e6cdabe0ddee7be6a650b6941a9d15c012f6708',
      1 => 
      array (
        0 => 'app\\domain\\services\\statsservice',
      ),
      2 => 
      array (
        0 => 'app\\domain\\services\\__construct',
        1 => 'app\\domain\\services\\totalsfordate',
        2 => 'app\\domain\\services\\totalsforrange',
        3 => 'app\\domain\\services\\calculatetotalsforrange',
        4 => 'app\\domain\\services\\calculatetotalsfordate',
        5 => 'app\\domain\\services\\accumulatemealstotals',
        6 => 'app\\domain\\services\\accumulatemealstotalscalories',
        7 => 'app\\domain\\services\\accumulatemealstotalsproteins',
        8 => 'app\\domain\\services\\accumulatemealstotalsfat',
        9 => 'app\\domain\\services\\accumulatemealstotalscarbs',
        10 => 'app\\domain\\services\\accumulatenutrientstotals',
        11 => 'app\\domain\\services\\returnrequestedfield',
        12 => 'app\\domain\\services\\cachekeyfordate',
        13 => 'app\\domain\\services\\cachekeyforrange',
        14 => 'app\\domain\\services\\cachetagsforuser',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Enums\\FoodTypeEnum.php' => 
    array (
      0 => 'e3347becee27394871cde0e686985c4b202fa7d9',
      1 => 
      array (
        0 => 'app\\enums\\foodtypeenum',
      ),
      2 => 
      array (
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Enums\\MealTypeEnum.php' => 
    array (
      0 => '0baee8bdd8e7eb024c0fdf26ae991f7fc32a6da6',
      1 => 
      array (
        0 => 'app\\enums\\mealtypeenum',
      ),
      2 => 
      array (
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Api\\ActivityController.php' => 
    array (
      0 => 'f1d7f0d9e2c64cc610d0f68e678016150f0e96b2',
      1 => 
      array (
        0 => 'app\\http\\controllers\\api\\activitycontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\api\\__construct',
        1 => 'app\\http\\controllers\\api\\index',
        2 => 'app\\http\\controllers\\api\\show',
        3 => 'app\\http\\controllers\\api\\update',
        4 => 'app\\http\\controllers\\api\\store',
        5 => 'app\\http\\controllers\\api\\destroy',
        6 => 'app\\http\\controllers\\api\\restore',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Api\\AuthController.php' => 
    array (
      0 => '293099de0bce2f27a2da5ec1651fd6302235a060',
      1 => 
      array (
        0 => 'app\\http\\controllers\\api\\authcontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\api\\__construct',
        1 => 'app\\http\\controllers\\api\\register',
        2 => 'app\\http\\controllers\\api\\login',
        3 => 'app\\http\\controllers\\api\\logout',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Api\\DailyStatsController.php' => 
    array (
      0 => '8ca870e6cb5610e8b8552059ec99fedb1aee4351',
      1 => 
      array (
        0 => 'app\\http\\controllers\\api\\dailystatscontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\api\\__construct',
        1 => 'app\\http\\controllers\\api\\daily',
        2 => 'app\\http\\controllers\\api\\range',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Api\\FoodController.php' => 
    array (
      0 => 'f7092a42876d6ce8927e76c38ace57e3ebea28f1',
      1 => 
      array (
        0 => 'app\\http\\controllers\\api\\foodcontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\api\\__construct',
        1 => 'app\\http\\controllers\\api\\index',
        2 => 'app\\http\\controllers\\api\\show',
        3 => 'app\\http\\controllers\\api\\store',
        4 => 'app\\http\\controllers\\api\\update',
        5 => 'app\\http\\controllers\\api\\destroy',
        6 => 'app\\http\\controllers\\api\\restore',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Api\\MealController.php' => 
    array (
      0 => '0e9b61a10a2a042bd3c8d5ed6d3485fd4ce84ab8',
      1 => 
      array (
        0 => 'app\\http\\controllers\\api\\mealcontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\api\\__construct',
        1 => 'app\\http\\controllers\\api\\index',
        2 => 'app\\http\\controllers\\api\\show',
        3 => 'app\\http\\controllers\\api\\store',
        4 => 'app\\http\\controllers\\api\\update',
        5 => 'app\\http\\controllers\\api\\destroy',
        6 => 'app\\http\\controllers\\api\\restore',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Api\\PlanController.php' => 
    array (
      0 => '701473cfe9819a501f3c3450169fbd2ec8e66482',
      1 => 
      array (
        0 => 'app\\http\\controllers\\api\\plancontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\api\\__construct',
        1 => 'app\\http\\controllers\\api\\index',
        2 => 'app\\http\\controllers\\api\\show',
        3 => 'app\\http\\controllers\\api\\store',
        4 => 'app\\http\\controllers\\api\\update',
        5 => 'app\\http\\controllers\\api\\destroy',
        6 => 'app\\http\\controllers\\api\\restore',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Api\\UserController.php' => 
    array (
      0 => '4ce02cc93a01448b461efc13b7f724ce7cea8447',
      1 => 
      array (
        0 => 'app\\http\\controllers\\api\\usercontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\api\\__construct',
        1 => 'app\\http\\controllers\\api\\index',
        2 => 'app\\http\\controllers\\api\\show',
        3 => 'app\\http\\controllers\\api\\showbyemail',
        4 => 'app\\http\\controllers\\api\\store',
        5 => 'app\\http\\controllers\\api\\update',
        6 => 'app\\http\\controllers\\api\\destroy',
        7 => 'app\\http\\controllers\\api\\restore',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Api\\UserRoleController.php' => 
    array (
      0 => 'faa3e4260ec444376d133f519f91533d5f7aef28',
      1 => 
      array (
        0 => 'app\\http\\controllers\\api\\userrolecontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\api\\__construct',
        1 => 'app\\http\\controllers\\api\\index',
        2 => 'app\\http\\controllers\\api\\show',
        3 => 'app\\http\\controllers\\api\\store',
        4 => 'app\\http\\controllers\\api\\update',
        5 => 'app\\http\\controllers\\api\\destroy',
        6 => 'app\\http\\controllers\\api\\restore',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Controller.php' => 
    array (
      0 => 'a33a5105f92c73a309c9f8a549905dcdf6dccbae',
      1 => 
      array (
        0 => 'app\\http\\controllers\\controller',
      ),
      2 => 
      array (
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Web\\ActivityController.php' => 
    array (
      0 => 'f236c8c9a5b6c683175e51d3d06c1da0291c53d0',
      1 => 
      array (
        0 => 'app\\http\\controllers\\web\\activitycontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\web\\search',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Web\\AdminActivityController.php' => 
    array (
      0 => 'f188927a1e636e52ce5398205f66a9f8b5160c4b',
      1 => 
      array (
        0 => 'app\\http\\controllers\\web\\adminactivitycontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\web\\__construct',
        1 => 'app\\http\\controllers\\web\\index',
        2 => 'app\\http\\controllers\\web\\search',
        3 => 'app\\http\\controllers\\web\\create',
        4 => 'app\\http\\controllers\\web\\store',
        5 => 'app\\http\\controllers\\web\\edit',
        6 => 'app\\http\\controllers\\web\\update',
        7 => 'app\\http\\controllers\\web\\destroy',
        8 => 'app\\http\\controllers\\web\\validatedata',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Web\\AdminController.php' => 
    array (
      0 => 'bd7552c04967a3d24d331179be6a4eacefb54105',
      1 => 
      array (
        0 => 'app\\http\\controllers\\web\\admincontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\web\\paginationparams',
        1 => 'app\\http\\controllers\\web\\dosearch',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Web\\AdminFoodController.php' => 
    array (
      0 => 'e6c8eef796dfdf6009ecfd58a57069836a1dca06',
      1 => 
      array (
        0 => 'app\\http\\controllers\\web\\adminfoodcontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\web\\__construct',
        1 => 'app\\http\\controllers\\web\\index',
        2 => 'app\\http\\controllers\\web\\search',
        3 => 'app\\http\\controllers\\web\\create',
        4 => 'app\\http\\controllers\\web\\store',
        5 => 'app\\http\\controllers\\web\\edit',
        6 => 'app\\http\\controllers\\web\\update',
        7 => 'app\\http\\controllers\\web\\destroy',
        8 => 'app\\http\\controllers\\web\\validatedata',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Web\\AdminPlanController.php' => 
    array (
      0 => '22dcf07a96a2cf4c708715fbc0c1cd7dc99a75da',
      1 => 
      array (
        0 => 'app\\http\\controllers\\web\\adminplancontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\web\\__construct',
        1 => 'app\\http\\controllers\\web\\index',
        2 => 'app\\http\\controllers\\web\\create',
        3 => 'app\\http\\controllers\\web\\store',
        4 => 'app\\http\\controllers\\web\\edit',
        5 => 'app\\http\\controllers\\web\\update',
        6 => 'app\\http\\controllers\\web\\destroy',
        7 => 'app\\http\\controllers\\web\\validatedata',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Web\\AdminUserController.php' => 
    array (
      0 => '95dfb27fd1f96cc351328d8c5059dc132ef558ce',
      1 => 
      array (
        0 => 'app\\http\\controllers\\web\\adminusercontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\web\\__construct',
        1 => 'app\\http\\controllers\\web\\index',
        2 => 'app\\http\\controllers\\web\\search',
        3 => 'app\\http\\controllers\\web\\edit',
        4 => 'app\\http\\controllers\\web\\update',
        5 => 'app\\http\\controllers\\web\\destroy',
        6 => 'app\\http\\controllers\\web\\validatedata',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Web\\AuthController.php' => 
    array (
      0 => 'd2c45bac2fc1be6a1108f59d7d5f1726aa70d3b1',
      1 => 
      array (
        0 => 'app\\http\\controllers\\web\\authcontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\web\\__construct',
        1 => 'app\\http\\controllers\\web\\showlogin',
        2 => 'app\\http\\controllers\\web\\login',
        3 => 'app\\http\\controllers\\web\\showregister',
        4 => 'app\\http\\controllers\\web\\register',
        5 => 'app\\http\\controllers\\web\\logout',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Web\\DashboardController.php' => 
    array (
      0 => '8552f8e1d6080d1def729d0a211085e63dafef0f',
      1 => 
      array (
        0 => 'app\\http\\controllers\\web\\dashboardcontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\web\\__construct',
        1 => 'app\\http\\controllers\\web\\index',
        2 => 'app\\http\\controllers\\web\\calculatetodaysmacros',
        3 => 'app\\http\\controllers\\web\\getcacheduseractivitiesfordate',
        4 => 'app\\http\\controllers\\web\\getmeals',
        5 => 'app\\http\\controllers\\web\\pickmealtypefortime',
        6 => 'app\\http\\controllers\\web\\computeaddmealtypeandcode',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Web\\FoodController.php' => 
    array (
      0 => '0ddd491cde64e2d5f9d17cd2b1e5d0ef092a425c',
      1 => 
      array (
        0 => 'app\\http\\controllers\\web\\foodcontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\web\\search',
        1 => 'app\\http\\controllers\\web\\more',
        2 => 'app\\http\\controllers\\web\\popup',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Web\\GoogleAuthController.php' => 
    array (
      0 => '93167606e9c1aa76a4355604588653d9c7cb068b',
      1 => 
      array (
        0 => 'app\\http\\controllers\\web\\googleauthcontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\web\\__construct',
        1 => 'app\\http\\controllers\\web\\redirect',
        2 => 'app\\http\\controllers\\web\\callback',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Web\\MealFoodController.php' => 
    array (
      0 => '9ddab099cb5dd95efb40314d98f4f65e17ab7429',
      1 => 
      array (
        0 => 'app\\http\\controllers\\web\\mealfoodcontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\web\\addfoods',
        1 => 'app\\http\\controllers\\web\\store',
        2 => 'app\\http\\controllers\\web\\updatefood',
        3 => 'app\\http\\controllers\\web\\removefood',
        4 => 'app\\http\\controllers\\web\\editmodal',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Web\\ProfileController.php' => 
    array (
      0 => 'e01449eea5b53705186e12a55da798822652f18d',
      1 => 
      array (
        0 => 'app\\http\\controllers\\web\\profilecontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\web\\__construct',
        1 => 'app\\http\\controllers\\web\\index',
        2 => 'app\\http\\controllers\\web\\showbodymetrics',
        3 => 'app\\http\\controllers\\web\\showsummary',
        4 => 'app\\http\\controllers\\web\\summarydata',
        5 => 'app\\http\\controllers\\web\\showplan',
        6 => 'app\\http\\controllers\\web\\showmacros',
        7 => 'app\\http\\controllers\\web\\showmacrosedit',
        8 => 'app\\http\\controllers\\web\\update',
        9 => 'app\\http\\controllers\\web\\updatepassword',
        10 => 'app\\http\\controllers\\web\\updatemacros',
        11 => 'app\\http\\controllers\\web\\showmacrosview',
        12 => 'app\\http\\controllers\\web\\formatrangedates',
        13 => 'app\\http\\controllers\\web\\updateplan',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Controllers\\Web\\UserActivitiesController.php' => 
    array (
      0 => '77d3b8367c8f972ac22094488bb56ec65dffb9e7',
      1 => 
      array (
        0 => 'app\\http\\controllers\\web\\useractivitiescontroller',
      ),
      2 => 
      array (
        0 => 'app\\http\\controllers\\web\\addactivity',
        1 => 'app\\http\\controllers\\web\\updateactivity',
        2 => 'app\\http\\controllers\\web\\removeactivity',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Middleware\\JwtMiddleware.php' => 
    array (
      0 => '8e6886cb895a3b81d65a61293fc34a9a97adae78',
      1 => 
      array (
        0 => 'app\\http\\middleware\\jwtmiddleware',
      ),
      2 => 
      array (
        0 => 'app\\http\\middleware\\handle',
        1 => 'app\\http\\middleware\\unauthorizedresponse',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Middleware\\RoleMiddleware.php' => 
    array (
      0 => 'e783852910c7569f32277b127e1b306e13e8fa75',
      1 => 
      array (
        0 => 'app\\http\\middleware\\rolemiddleware',
      ),
      2 => 
      array (
        0 => 'app\\http\\middleware\\handle',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Requests\\StoreActivityRequest.php' => 
    array (
      0 => 'ca7705854e5576595aa883a534073c8ecbadc5d5',
      1 => 
      array (
        0 => 'app\\http\\requests\\storeactivityrequest',
      ),
      2 => 
      array (
        0 => 'app\\http\\requests\\authorize',
        1 => 'app\\http\\requests\\prepareforvalidation',
        2 => 'app\\http\\requests\\failedvalidation',
        3 => 'app\\http\\requests\\rules',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Requests\\StoreFoodRequest.php' => 
    array (
      0 => '924a766de50a719efde2f39ff2a541af3e452806',
      1 => 
      array (
        0 => 'app\\http\\requests\\storefoodrequest',
      ),
      2 => 
      array (
        0 => 'app\\http\\requests\\authorize',
        1 => 'app\\http\\requests\\prepareforvalidation',
        2 => 'app\\http\\requests\\failedvalidation',
        3 => 'app\\http\\requests\\rules',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Requests\\StoreMealRequest.php' => 
    array (
      0 => '872f5ea7d465e196359389f913e877bdf159bd35',
      1 => 
      array (
        0 => 'app\\http\\requests\\storemealrequest',
      ),
      2 => 
      array (
        0 => 'app\\http\\requests\\authorize',
        1 => 'app\\http\\requests\\prepareforvalidation',
        2 => 'app\\http\\requests\\failedvalidation',
        3 => 'app\\http\\requests\\rules',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Requests\\StorePlanRequest.php' => 
    array (
      0 => '1fb809d87a72fb0a8227f2ce6f46966bbf68044b',
      1 => 
      array (
        0 => 'app\\http\\requests\\storeplanrequest',
      ),
      2 => 
      array (
        0 => 'app\\http\\requests\\authorize',
        1 => 'app\\http\\requests\\prepareforvalidation',
        2 => 'app\\http\\requests\\failedvalidation',
        3 => 'app\\http\\requests\\rules',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Requests\\StoreUserRequest.php' => 
    array (
      0 => '45669a1fbbe8b948c3858c0da64f8da18a317700',
      1 => 
      array (
        0 => 'app\\http\\requests\\storeuserrequest',
      ),
      2 => 
      array (
        0 => 'app\\http\\requests\\authorize',
        1 => 'app\\http\\requests\\prepareforvalidation',
        2 => 'app\\http\\requests\\failedvalidation',
        3 => 'app\\http\\requests\\rules',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Requests\\StoreUserRoleRequest.php' => 
    array (
      0 => '22befd902aa699293a1feaa580ae224c1cf2cefc',
      1 => 
      array (
        0 => 'app\\http\\requests\\storeuserrolerequest',
      ),
      2 => 
      array (
        0 => 'app\\http\\requests\\authorize',
        1 => 'app\\http\\requests\\prepareforvalidation',
        2 => 'app\\http\\requests\\failedvalidation',
        3 => 'app\\http\\requests\\rules',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Requests\\UpdateActivityRequest.php' => 
    array (
      0 => '071b85ec40c9a49201a9e41ca6b05d9b3d9f50ec',
      1 => 
      array (
        0 => 'app\\http\\requests\\updateactivityrequest',
      ),
      2 => 
      array (
        0 => 'app\\http\\requests\\authorize',
        1 => 'app\\http\\requests\\prepareforvalidation',
        2 => 'app\\http\\requests\\failedvalidation',
        3 => 'app\\http\\requests\\rules',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Requests\\UpdateFoodRequest.php' => 
    array (
      0 => '40dce2bc8d1ab2d4f4a0a9c0c238dbae87b9ea50',
      1 => 
      array (
        0 => 'app\\http\\requests\\updatefoodrequest',
      ),
      2 => 
      array (
        0 => 'app\\http\\requests\\authorize',
        1 => 'app\\http\\requests\\prepareforvalidation',
        2 => 'app\\http\\requests\\failedvalidation',
        3 => 'app\\http\\requests\\rules',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Requests\\UpdateMealRequest.php' => 
    array (
      0 => '7e793da5a9fb0950a8b8fa67332419a2f55763d0',
      1 => 
      array (
        0 => 'app\\http\\requests\\updatemealrequest',
      ),
      2 => 
      array (
        0 => 'app\\http\\requests\\authorize',
        1 => 'app\\http\\requests\\prepareforvalidation',
        2 => 'app\\http\\requests\\failedvalidation',
        3 => 'app\\http\\requests\\rules',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Requests\\UpdatePasswordRequest.php' => 
    array (
      0 => '50fe29236fa0a349842fec904704d2724917d573',
      1 => 
      array (
        0 => 'app\\http\\requests\\updatepasswordrequest',
      ),
      2 => 
      array (
        0 => 'app\\http\\requests\\authorize',
        1 => 'app\\http\\requests\\rules',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Requests\\UpdatePlanRequest.php' => 
    array (
      0 => '884b5a1d7e66949c6c8d7bad6c2201b9204fdaa6',
      1 => 
      array (
        0 => 'app\\http\\requests\\updateplanrequest',
      ),
      2 => 
      array (
        0 => 'app\\http\\requests\\authorize',
        1 => 'app\\http\\requests\\prepareforvalidation',
        2 => 'app\\http\\requests\\failedvalidation',
        3 => 'app\\http\\requests\\rules',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Requests\\UpdateUserRequest.php' => 
    array (
      0 => '1dbf5da0d6aece59af52af86eaa8773a80245215',
      1 => 
      array (
        0 => 'app\\http\\requests\\updateuserrequest',
      ),
      2 => 
      array (
        0 => 'app\\http\\requests\\authorize',
        1 => 'app\\http\\requests\\prepareforvalidation',
        2 => 'app\\http\\requests\\failedvalidation',
        3 => 'app\\http\\requests\\rules',
        4 => 'app\\http\\requests\\attributes',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Requests\\UpdateUserRoleRequest.php' => 
    array (
      0 => 'c92f773a4fe21aa034bdcee9f97f0e27b50aa055',
      1 => 
      array (
        0 => 'app\\http\\requests\\updateuserrolerequest',
      ),
      2 => 
      array (
        0 => 'app\\http\\requests\\authorize',
        1 => 'app\\http\\requests\\prepareforvalidation',
        2 => 'app\\http\\requests\\failedvalidation',
        3 => 'app\\http\\requests\\rules',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Resources\\ActivityResource.php' => 
    array (
      0 => 'e913f4253645a19b1ae73b87833c4b2357504fd0',
      1 => 
      array (
        0 => 'app\\http\\resources\\activityresource',
      ),
      2 => 
      array (
        0 => 'app\\http\\resources\\toarray',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Resources\\FoodResource.php' => 
    array (
      0 => '0743f7631f1e1b31c090b57ef6d550d87166ffdc',
      1 => 
      array (
        0 => 'app\\http\\resources\\foodresource',
      ),
      2 => 
      array (
        0 => 'app\\http\\resources\\toarray',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Resources\\MealResource.php' => 
    array (
      0 => 'e9aa19c46bd46af69b6abc48a37068a9c591779f',
      1 => 
      array (
        0 => 'app\\http\\resources\\mealresource',
      ),
      2 => 
      array (
        0 => 'app\\http\\resources\\toarray',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Resources\\PlanResource.php' => 
    array (
      0 => 'afd62c86bfbb954add4439af4aeef7a6c7d1482b',
      1 => 
      array (
        0 => 'app\\http\\resources\\planresource',
      ),
      2 => 
      array (
        0 => 'app\\http\\resources\\toarray',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Resources\\UserResource.php' => 
    array (
      0 => '5d203d915deb862496d2c6534e5ddbdf39d69358',
      1 => 
      array (
        0 => 'app\\http\\resources\\userresource',
      ),
      2 => 
      array (
        0 => 'app\\http\\resources\\toarray',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Http\\Resources\\UserRoleResource.php' => 
    array (
      0 => 'c49b69e2af5727abc29433abdc216ef47be75b4d',
      1 => 
      array (
        0 => 'app\\http\\resources\\userroleresource',
      ),
      2 => 
      array (
        0 => 'app\\http\\resources\\toarray',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Jobs\\ProcessFoodImage.php' => 
    array (
      0 => '1d1a4449673c8f2861f3de2cae67f2985e102ea9',
      1 => 
      array (
        0 => 'app\\jobs\\processfoodimage',
      ),
      2 => 
      array (
        0 => 'app\\jobs\\__construct',
        1 => 'app\\jobs\\handle',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Providers\\AppServiceProvider.php' => 
    array (
      0 => '01bf9e5cf5bb666446625056b618445ae4749675',
      1 => 
      array (
        0 => 'app\\providers\\appserviceprovider',
      ),
      2 => 
      array (
        0 => 'app\\providers\\register',
        1 => 'app\\providers\\boot',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\Providers\\RepositoryServiceProvider.php' => 
    array (
      0 => '68fe35445faaeba3acb71af52d8ce1ffeff68d02',
      1 => 
      array (
        0 => 'app\\providers\\repositoryserviceprovider',
      ),
      2 => 
      array (
        0 => 'app\\providers\\register',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\View\\Components\\dashboard\\ActivitiesEditPopup.php' => 
    array (
      0 => 'a998245001bb662d267cf473387a10c437e6db16',
      1 => 
      array (
        0 => 'app\\view\\components\\dashboard\\activitieseditpopup',
      ),
      2 => 
      array (
        0 => 'app\\view\\components\\dashboard\\__construct',
        1 => 'app\\view\\components\\dashboard\\render',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\View\\Components\\dashboard\\ActivitiesPopup.php' => 
    array (
      0 => '714424f6bdf8ae4a0e4a3735651f035de741fc91',
      1 => 
      array (
        0 => 'app\\view\\components\\dashboard\\activitiespopup',
      ),
      2 => 
      array (
        0 => 'app\\view\\components\\dashboard\\__construct',
        1 => 'app\\view\\components\\dashboard\\render',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\View\\Components\\dashboard\\ActivityGrid.php' => 
    array (
      0 => '7c051208407203c3fc57c332dd5ec515f07b1318',
      1 => 
      array (
        0 => 'app\\view\\components\\dashboard\\activitygrid',
      ),
      2 => 
      array (
        0 => 'app\\view\\components\\dashboard\\__construct',
        1 => 'app\\view\\components\\dashboard\\render',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\View\\Components\\dashboard\\FoodCards.php' => 
    array (
      0 => '53b8f5fc5bae6080057dcfd98e8551fa982c4779',
      1 => 
      array (
        0 => 'app\\view\\components\\foodcards',
      ),
      2 => 
      array (
        0 => 'app\\view\\components\\__construct',
        1 => 'app\\view\\components\\render',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\View\\Components\\dashboard\\FoodEditPopup.php' => 
    array (
      0 => 'c7ad06375d249820fcb3db7eb0bb7bc66955e8f7',
      1 => 
      array (
        0 => 'app\\view\\components\\dashboard\\foodeditpopup',
      ),
      2 => 
      array (
        0 => 'app\\view\\components\\dashboard\\__construct',
        1 => 'app\\view\\components\\dashboard\\render',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\View\\Components\\dashboard\\FoodGrid.php' => 
    array (
      0 => 'b3befa3f9eb07dbc593b2fe9991729b4a14107e9',
      1 => 
      array (
        0 => 'app\\view\\components\\dashboard\\foodgrid',
      ),
      2 => 
      array (
        0 => 'app\\view\\components\\dashboard\\__construct',
        1 => 'app\\view\\components\\dashboard\\render',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\View\\Components\\dashboard\\TodaysActivitiesList.php' => 
    array (
      0 => '0e56e0e1178339c8daea142a7076d351f23f4e83',
      1 => 
      array (
        0 => 'app\\view\\components\\dashboard\\todaysactivitieslist',
      ),
      2 => 
      array (
        0 => 'app\\view\\components\\dashboard\\__construct',
        1 => 'app\\view\\components\\dashboard\\render',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\View\\Components\\MMButton.php' => 
    array (
      0 => '904accc6cccd7bb7f7b7a656ded4b57f4a906ae6',
      1 => 
      array (
        0 => 'app\\view\\components\\mmbutton',
      ),
      2 => 
      array (
        0 => 'app\\view\\components\\__construct',
        1 => 'app\\view\\components\\render',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\View\\Components\\MMInput.php' => 
    array (
      0 => '3c97aa77b7692afb4e66de7803df9a210a60a8c6',
      1 => 
      array (
        0 => 'app\\view\\components\\mminput',
      ),
      2 => 
      array (
        0 => 'app\\view\\components\\__construct',
        1 => 'app\\view\\components\\render',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\View\\Components\\MMSelect.php' => 
    array (
      0 => '0d3c67e5d55b62535748b7e6512b2860cab41dfa',
      1 => 
      array (
        0 => 'app\\view\\components\\mmselect',
      ),
      2 => 
      array (
        0 => 'app\\view\\components\\__construct',
        1 => 'app\\view\\components\\render',
      ),
      3 => 
      array (
      ),
    ),
    'C:\\Users\\Yevhen\\Desktop\\programming_lessons\\PHP\\Laravel\\calories_tracker\\app\\View\\Components\\SocialButton.php' => 
    array (
      0 => '82f73fb3d9e7a83b6c290564f610a7f5e3861504',
      1 => 
      array (
        0 => 'app\\view\\components\\socialbutton',
      ),
      2 => 
      array (
        0 => 'app\\view\\components\\__construct',
        1 => 'app\\view\\components\\render',
      ),
      3 => 
      array (
      ),
    ),
  ),
));