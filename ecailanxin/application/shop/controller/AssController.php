<?php
namespace app\shop\controller;
use think\Controller;
use think\Db;
use think\Request;
include EXTEND_PATH.'/qrcode/qrcode.php';
//print_r(EXTEND_PATH);die;
use qrcode\QRcode;

class AssController extends Controller
{

    public function aaa()
    {

        //header('content-type:image/png');  //设置gif Image
        ob_clean();
        $url = urldecode("www.baidu.com");//连接后跳转地址
        $qrcode = new QRcode();
        //1.第一个参数URL网址参数，
        //2.第二个参数默认为否，不生成文件，只将二维码图片返回，否则需要给出存放生成二维码图片的路径
        //3.第三个参数$level默认为L，这个参数可传递的值分别是L(QR_ECLEVEL_L，7%)，M(QR_ECLEVEL_M，15%)，Q(QR_ECLEVEL_Q，25%)，H(QR_ECLEVEL_H，30%)。这个参数控制二维码容错率，不同的参数表示二维码可被覆盖的区域百分比。利用二维维码的容错率，我们可以将头像放置在生成的二维码图片任何区域。
        //4.第四个参数$size，控制生成图片的大小，默认为4
        //5.第五个参数$margin，控制生成二维码的空白区域大小
        //6.第六个参数$saveandprint，保存二维码图片并显示出来，$outfile必须传递图片路径。
        $png = QRcode::png($url, false, "H", 4, 1);
        $imageString = base64_encode(ob_get_contents());
        ob_end_clean();
        $png = "data:image/jpg;base64," . $imageString;

        $this->assign("png", $png);
        return $this->fetch();

    }

    public function bb()
    {
        $img_height = 100; //设置图像高度
        $img_width = 300; //设置图像宽度
        $img = imagecreate($img_width,$img_height); //创建图像
//设置颜色值
        $black = imagecolorallocate($img, 0, 0, 0); //黑色
        $white = imagecolorallocate($img, 255, 255, 255); //白色
        imagefill($img, 0, 0, $black); //背景颜色
       // imagestring($img, 50, 300, 100, 123456, $black);

//因为 imagestring() 貌似不支持设置字体大小和utf-8，所以使用 imagettftext() 把字符串添加到图像上

        $code = "验证码"; //图像要显示的字符串内容

        $font_size = 50; //字体大小
        $roll = 0; //旋转角度
        $x = 50; //x坐标，字符从图像左上角向右移动多少个单位
        $y = 75; //-y坐标，字符从图像左上角向下移动多少个单位
        $file_ttf = EXTEND_PATH."/qrcode/test.ttf"; //字体文件，例如宋体楷书什么的，放在哪都行（当前是放在根目录）
        imagettftext($img, $font_size, $roll, $x, $y, $black, $file_ttf, $code);

        header("Content-type:image/png"); //记得要以图片形式输出
//        echo $img;
        imagepng($img);
        imagedestroy($img);
//        exit();
    }


        public  function sys()
        {
			echo  phpinfo();
         //return redirect('index/login/login');

//            echo '这是参数值:',$www;
            //return $_SERVER['REQUEST_TIME'];
//            return $this->fetch();
        }

      public function daojishi(){
          $time  = strtotime(date("Y-m-d H:i:s")); //当前系统时间
          $time1 = strtotime('2019-02-04'); //放假时间
          $time2 = strtotime('2019-01-01'); //元旦时间
          $sub   = ceil(($time1 - $time)/3600);
          $sub2 =  ceil(($time2 - $time)/86400);

          echo "距离放假还有",$sub,"小时</<br>>";
          echo "距离元旦还有",$sub2,"天";
          $end_time = $this->run_time();
//           return $time;
      }

      public  function run_time(){
         list($msec,$sec)=explode("",microtime());

         return ((float)$msec+(float)$sec);
      }

}
