<?php

return [
    'adminEmail' => 'admin@example.com',
    'adminAcronym' => 'CJS',
    'adminTitle' => 'CheJs',
    'adminDefaultHomePage' => ['main/system'], // 默认主页

    /** ------ 总管理员配置 ------ **/
    'adminAccount' => 1,// 系统管理员账号id
    'isMobile' => false, // 手机访问

    /** ------ 日志记录 ------ **/
    'user.log' => true,
    'user.log.level' => ['error'], // 级别 ['info', 'warning', 'error']
    'user.log.noPostData' => [ // 安全考虑,不接收Post存储到日志的路由
        'backend/site/login',
        'sys/manager/up-password',
        'sys/manager/ajax-edit',
        'member/member/ajax-edit',
    ],
    'user.log.except.code' => [404], // 不记录的code

    /** ------ 开发者信息 ------ **/
    'exploitDeveloper' => '简言',
    'exploitFullName' => 'RageFrame应用开发引擎',
    'exploitOfficialWebsite' => '<a href="http://www.rageframe.com" target="_blank">www.rageframe.com</a>',
    'exploitGitHub' => '<a href="https://github.com/jianyan74/rageframe2" target="_blank">https://github.com/jianyan74/rageframe2</a>',

    /** ------ 备份配置配置 ------ **/
    'dataBackupPath' => Yii::getAlias('@root') . '/console/backup', // 数据库备份根路径
    'dataBackPartSize' => 20971520,// 数据库备份卷大小
    'dataBackCompress' => 1,// 压缩级别
    'dataBackCompressLevel' => 9,// 数据库备份文件压缩级别
    'dataBackLock' => 'backup.lock',// 数据库备份锁

    /** ------ 行为日志 ------ **/
    'behaviorLog' => [
        // 请求之前
        'before' => [
            'backend/site/login' => [
                'method' => '*',
                'alias' => '',
                'postRecord' => true,
            ]
        ],
        // 请求之后
        'after' => [

        ]
    ],

    /**
     * 不需要验证的路由全称
     *
     * 注意: 前面以绝对路径/为开头
     */
    'noAuthRoute' => [
        '/main/index',// 系统主页
        '/main/system',// 系统首页
        '/wechat/qrcode/qr',// 二维码管理的二维码
    ],

    /** ------ 配置文本类型 ------ **/
    'configTypeList' => [
        'text' => "文本框",
        'password' => "密码框",
        'secretKeyText' => "密钥文本框",
        'textarea' => "文本域",
        'date' => "日期",
        'time' => "时间",
        'datetime' => "日期时间",
        'dropDownList' => "下拉文本框",
        'multipleInput' => "Input组",
        'radioList' => "单选按钮",
        'checkboxList' => "复选框",
        'baiduUEditor' => "百度编辑器",
        'image' => "图片上传",
        'images' => "多图上传",
        'file' => "文件上传",
        'files' => "多文件上传",
        'cropper' => "图片裁剪上传",
        'latLngSelection' => "经纬度选择",
    ],

    /**
     * 技师类型
     */
    'ArtificerType' => [
        1 => '常驻技师',
        2 => '常驻可外协技师',
        3 => '自由技师',
    ],

    /** ------ 插件类型 ------ **/
    'addonsGroup' => [
        'plug' => [
            'name' => 'plug',
            'title' => '功能扩展',
            'icon' => 'fa fa-puzzle-piece',
        ],
        'business' => [
            'name' => 'business',
            'title' => '主要业务',
            'icon' => 'fa fa-random',
        ],
        'customer' => [
            'name' => 'customer',
            'title' => '客户关系',
            'icon' => 'fa fa-rocket',
        ],
        'activity' => [
            'name' => 'activity',
            'title' => '营销及活动',
            'icon' => 'fa fa-tachometer',
        ],
        'services' => [
            'name' => 'services',
            'title' => '常用服务及工具',
            'icon' => 'fa fa-magnet',
        ],
        'biz' => [
            'name' => 'biz',
            'title' => '行业解决方案',
            'icon' => 'fa fa-diamond',
        ],
        'h5game' => [
            'name' => 'h5game',
            'title' => 'H5游戏',
            'icon' => 'fa fa-gamepad',
        ],
    ],

    /** ------ 微信配置-------------------**/

    // 素材类型
    'wechatMediaType' => [
        'news' => '微信图文',
        'image' => '图片',
        'voice' => '语音',
        'video' => '视频',
    ],

    // 微信级别
    'wechatLevel' => [
        '1' => '普通订阅号',
        '2' => '普通服务号',
        '3' => '认证订阅号',
        '4' => '认证服务号/认证媒体/政府订阅号',
    ],

    /** ------ 微信个性化菜单 ------ **/

    // 性别
    'individuationMenuSex' => [
        '' => '不限',
        1 => '男',
        2 => '女',
    ],

    // 员工身份
    'identity' => [
        '' => '不限',
        1 => '外拓调度',
        2 => '外拓人员',
    ],

    // 订单状态
    'OrderStatus' => [
        '' => '不限',
        10 => '新订单',
        20 => '任务中',
        30 => '出单失败',
        40 => '维修失败',
    ],

    //
    'GoodsAdap'=>[
        1 => '10万以下',
        2 => '10-20万',
        3 => '20-30万',
        4 => '30-50万',
        5 => '50-70万',
        6 => '70-100万',
        7 => '100万以上',
    ],

    /*用户上报成功后 ， 外拓人员确认完成后返现*/
        'Succ_Cash' => '10',

    // 客户端版本
    'individuationMenuClientPlatformType' => [
        '' => '不限',
        1 => 'IOS(苹果)',
        2 => 'Android(安卓)',
        3 => 'Others(其他)',
    ],

    // 语言
    'individuationMenuLanguage' => [
        '' => '不限',
        'zh_CN' => '简体中文',
        'zh_TW' => '繁体中文TW',
        'zh_HK' => '繁体中文HK',
        'en' => '英文',
        'id' => '印尼',
        'ms' => '马来',
        'es' => '西班牙',
        'ko' => '韩国',
        'it' => '意大利',
        'ja' => '日本',
        'pl' => '波兰',
        'pt' => '葡萄牙',
        'ru' => '俄国',
        'th' => '泰文',
        'vi' => '越南',
        'ar' => '阿拉伯语',
        'hi' => '北印度',
        'he' => '希伯来',
        'tr' => '土耳其',
        'de' => '德语',
        'fr' => '法语',
    ],
];