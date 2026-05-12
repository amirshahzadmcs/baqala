<?php $this->load->view("front/common/header");?>

<div class="wrappage">


<div class="innerpageban"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3771.721538563599!2d73.06588106421204!3d19.031988258301634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c26b3deb4f73%3A0xe0265268047c4908!2sShree%20Shanti%20Niketan%20-%20C!5e0!3m2!1sen!2sin!4v1586851128710!5m2!1sen!2sin" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe></div>
  

<div class="row-fluid">
<ol class="breadcrumb">
    <li><a href="#">Home</a></li>
    <li class="active">Contact Us</li>        
  </ol>
</div>




<div class="container">
<ul class="tabs title-bar-tabs"> <li class="active"><a href="#">Contact Us</a></li> </ul>
</div>

<div class="container subhadding"><center>Feel Free To Contact Us About Anything, Anytime<center></div>
<div class="webcontent"><p><center>We'll follow up with you as soon as possible<br />
You can also email us at <strong>info@shuddhdesiorganic.com</strong> to fasten up the support process</center></p></div>


<div class="container webcontent wrappad">

<div class="col-sm-6 contactdetail">
<h3><strong>Office :</strong></h3>

<p><i class="fa fa-map-marker"></i> Shuddh Desi Organic<br/>
Plot-90,Vinayak Vihar Colony,Opposite Baba Paradise,
<br/>Main Patrkar road,Golyawas,Mansarovar-302020,Jaipur</p>

<p><i class="fa fa-envelope"></i> info@shuddhdesiorganic.com</p>

<p><i class="fa fa-mobile"></i> 8890405026 (9AM to 8PM)</p>

<p><i class="fa fa-globe"></i> www.shuddhdesiorganic.com</p>
</div>



<div class="col-sm-6 formbox">
<div class="col-sm-12 form-group"><h3><strong>We have 24 hours email support</strong></h3></div>
<?php echo form_open("home/submit_contact_us");?>
<div class="col-sm-6 form-group"><input name="name" type="text" required class="form-control" placeholder="Name" /></div>
<div class="col-sm-6 form-group"><input name="email" type="email" required class="form-control" placeholder="Email" /></div>
<div class="col-sm-6 form-group"><input name="mobile" type="text" required class="form-control" placeholder="Mobile" /></div>
<div class="col-sm-6 form-group"><input name="subject" type="text"  class="form-control" placeholder="Subject" /></div>
<div class="col-sm-12 form-group"><textarea name="message" cols="" required rows="" placeholder="Message" class="form-control"></textarea></div>
<div class="col-sm-12 form-group"><button class="btn btn-lg btn-primary" type="submit">Submit</button></div>
<?php echo form_close();?>
</div>



</div>



<?php $this->load->view("front/common/footer");?>
