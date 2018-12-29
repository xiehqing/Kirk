<?php
# =================== 模板Demo =================== Start
$config['router']['Admin\Demo\Index'] = array(
    '^\/demo\/index.html$'
);
$config['router']['Admin\Demo\Blank'] = array(
    '^\/demo\/blank.html$'
);
$config['router']['Admin\Demo\Buttons'] = array(
    '^\/demo\/buttons.html$'
);
$config['router']['Admin\Demo\Flot'] = array(
    '^\/demo\/flot.html$'
);
$config['router']['Admin\Demo\Forms'] = array(
    '^\/demo\/forms.html$'
);
$config['router']['Admin\Demo\Grid'] = array(
    '^\/demo\/grid.html$'
);
$config['router']['Admin\Demo\Icons'] = array(
    '^\/demo\/icons.html$'
);
$config['router']['Admin\Demo\Index'] = array(
    '^\/demo\/index.html$'
);
$config['router']['Admin\Demo\Login'] = array(
    '^\/demo\/login.html$'
);
$config['router']['Admin\Demo\Morris'] = array(
    '^\/demo\/morris.html$'
);
$config['router']['Admin\Demo\Notifications'] = array(
    '^\/demo\/notifications.html$'
);
$config['router']['Admin\Demo\PanelsWells'] = array(
    '^\/demo\/panels-wells.html$'
);
$config['router']['Admin\Demo\Tables'] = array(
    '^\/demo\/tables.html$'
);
$config['router']['Admin\Demo\Typography'] = array(
    '^\/demo\/typography.html$'
);
# =================== 模板Demo =================== End


# Index
$config['router']['Admin\Index'] = array(
    '^\/*$'
);

# 登录
$config['router']['Admin\Login'] = array(
    '^\/login\/$'
);

# 接口模块
$config['router']['Admin\Api\Login'] = array(
    '^\/api\/login$'
);

# 爬虫模块
$config['router']['Admin\Spider\Index'] = array(
    '^\/spider\/index.html$'
);
$config['router']['Admin\Spider\Analysis'] = array(
    '^\/spider\/analysis$'
);

# 账号模块
$config['router']['Admin\Account\Index'] = array(
    '^\/account\/$'
);
$config['router']['Admin\Account\Setting'] = array(
    '^\/account\/setting$'
);

