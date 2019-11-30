<?php
use common\helpers\Url;
use common\helpers\Html;

$this->title = '首页';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<?= Html::jsFile('https://webapi.amap.com/maps?v=1.4.15&key=fb39e0f374bfe28a30d2031d7a8137de')?>

<div class="row">

    <div class="col-lg-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-cog"></i> 门店统计</h3>
            </div>
            <div class="box-body table-responsive">
                <table class="table">
                    <tr>
                        <td width="150px">当前门店数量：</td>
                        <td><?= $storm ?>&nbsp;&nbsp;家</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        地图：
        <div id="container" style="height: 1000px;"></div>
        <div id="status" style="display: none"></div>
        <div id="result" style="display: none"></div>
    </div>
</div>


<script type="text/javascript">
    var map = new AMap.Map("container", {
        zoom: 12,
        // center: [113.68133,34.72864],
        resizeEnable: true
    });

    AMap.plugin('AMap.Geolocation', function() {
        var geolocation = new AMap.Geolocation({
            enableHighAccuracy: true,//是否使用高精度定位，默认:true
            timeout: 10000,          //超过10秒后停止定位，默认：5s
            buttonPosition:'RB',    //定位按钮的停靠位置
            buttonOffset: new AMap.Pixel(10, 20),//定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
            zoomToAccuracy: true,   //定位成功后是否自动调整地图视野到定位点
        });
        map.addControl(geolocation);
    });
    var lnglats = <?= json_encode($report)?>;
    var markers = [];
    // 创建一个 Icon
    /*'https://webapi.amap.com/theme/v1.3/markers/n/mark_b.png',*/
    var infoWindow = new AMap.InfoWindow({offset: new AMap.Pixel(0, -30)});
    for (var i = 0; i < lnglats.length; i++) {
        var lnglat = lnglats[i];
        // 创建点实例
        var marker = new AMap.Marker({
            position: new AMap.LngLat(lnglat['longitude'], lnglat['latitude']),
            icon: 'https://api.chejiangshan.com/sos.png',
            extData: {
                id: i + 1
            }
        });

        marker.content = '我是第' + (i + 1) + '个Marker';
        marker.on('mouseover', markerClick);
        markers.push(marker);
    }
    function markerClick(e) {
        infoWindow.setContent(e.target.content);
        infoWindow.open(map, e.target.getPosition());
    }
    var overlayGroups = new AMap.OverlayGroup(markers);
    window.onload=function(){
        addOverlayGroup();
    };
    // 添加覆盖物群组
    function addOverlayGroup() {
        map.add(overlayGroups);
    }
</script>