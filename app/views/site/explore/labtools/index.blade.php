@extends ('layouts.master')
@section('content')
 <div>
      <div id="intro">
        <h3 style="color: #34a26a;"> Digital Experience Laboratory Tools</h3>
       
        <h4>The FabLab at University Bremen: A place to come for making, learning and sharing.</h4>
        <p> The FabLab Tools library should help you to get a quick idea about the usage of tools in FabLab.Share this experience.
You are free to suggest a new component for the library. We consider your recommendation.</p>
      </div>
      &nbsp;
      <div style="background-color: #34a26a; width: 100%;"><p style="padding: 5px; color: #ffffff;">Learn about these awesome tools!</p></div>
     &nbsp;
      <div id="machine-details">
        <div class="machine-list">
          <div id="description">
            <div class="machine-pic"><img src="/img/fablabtools/laserCutter.jpg"></div>
            <div class="machine-info"><p><strong>Laser Cutter: </strong>Laser cutting is a technology that uses a laser to cut materials. It works by 
              directing the output of a high-power laser, by computer, at the material to be cut. The material then
             either melts, burns, vaporizes away, or is blown away by a jet of gas,leaving an edge with a high-quality surface finish.</p>
            
              <ul>
                <li><a href="/uploads/files/LaserDraw 9 - English (EngraveLab 9).pdf" target="_blank">LaserDraw 9 - English</a></li>
                <li><a href="/uploads/files/Laserdraw 9 - German.pdf" target="_blank">LaserDraw 9 - German</a></li>
                <li><a href="/uploads/files/Zing - English.pdf" target="_blank">Zing LaserCutter - English</a></li>
                <li><a href="/uploads/files/Zing - German.pdf" target="_blank">Zing LaserCutter - German</a></li>
                <li><a href="/uploads/files/Zing - German.pdf" target="_blank">Zing LaserCutter Setting</a></li>
              </ul>
              <p>For more Informations about the Laser Cutter have a look at the <a href="http://www.fablab-bremen.org/wiki/doku.php?id=public:zing6030" target="_blank">Laser Cutter Wiki entry</a></p>
            </div>        
          </div>
          &nbsp;

          <div id="description">
            <div class="machine-pic"><img src="/img/fablabtools/3DPrinter.jpg"></div>
            <div class="machine-info"><p><strong>3D Printer: </strong>3D printing is a process of making a three-dimensional
             solid object of virtually any shape from a digital model. 3D printing is achieved using an additive process, 
            where successive layers of material are laid down in different shapes.</p>

            <ul>
              <li><a href="/uploads/files/Ultimaker.pdf" target="_blank">3D Printer Ultimaker - English</a></li>
              <li><a href="/uploads/files/Prusa.pdf" target="_blank">3D Printer Prusa - English</a></li>
            </ul>
            <p>For more Informations about the 3D printers have a look at the <a href="http://www.fablab-bremen.org/wiki/doku.php?id=ultimaker" target="_blank">Ultimaker Classic Wiki entry</a> or the <a href="http://www.fablab-bremen.org/wiki/doku.php?id=ultimaker2" target="_blank">Ultimaker 2 Wiki entry</a></p>
            </div>        
          </div>
          &nbsp;
          <div id="description">
            <div class="machine-pic"><img src="/img/fablabtools/VinylCutters.jpg"></div>
            <div class="machine-info"><p>A <strong>vinyl cutter </strong>is a type of computer controlled machine.
             Small vinyl cutters look like computer printers. The computer controls the movement of a sharp blade. 
              This blade is used to cut out shapes and letters from sheets of thin self-adhesive plastic (vinyl).</p>
            <ul>
              <li><a href="http://www.youtube.com/watch?v=TRGZ3cuO3Nc" target="_blank">How to Cut Vinyl</a></li>
              <li><a href="http://www.youtube.com/watch?v=UyQE8bY1-Mw" target="_blank">Cutting ThermoFlex Plus</a></li>

              <li><a href="http://www.youtube.com/watch?v=gMcWKW8Ep70" target="_blank">How to Print and Cut</a></li>
              <li><a href="http://www.youtube.com/watch?v=bA7jgv8BA-w" target="_blank">Printable Heat Transfer Material</a></li>
              <li><a href="http://www.youtube.com/watch?v=Ipjvy_94Ke8" target="_blank">How to make a T-Shirt</a></li>
              <li><a href="http://www.youtube.com/watch?v=IBAh_fF38Ik" target="_blank">Cutting Fabric</a></li>
            </ul>
            <p>For more Informations about the Vinyl Cutter have a look at the <a href="http://www.fablab-bremen.org/wiki/doku.php?id=silhouette_cameo" target="_blank">Vinyl Cutter Wiki entry</a></p>
            </div>        
          </div>  
          &nbsp;

        </div>
      </div>
  </div>
<style type="text/css">
a{
  color:#34a26a;
}
a:hover{
  color:#34a26a;
}
</style>
@stop