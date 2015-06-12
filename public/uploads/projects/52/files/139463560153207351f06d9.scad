// Variablen
materialThickness = 4.05;
ringR = 27;
ringH = 2 * materialThickness + 6;
holderR = 4.05;
holderH = 4.8;
armholderR = 6.5;
armholderH = ringH;
screwHoleR = 1.5;


//Modules

module halfaring(h, r) {
	difference()
	{
		cylinder(h = h, r = r + 1.5, $fn = 100, center = true);
		cylinder(h = h + 0.1, r = r, $fn = 100, center = true);
		translate([-r/2 - 1.5 - holderR * 1.2, 0, 0])
		cube(size = [ r + 1.5, 2 * (r + 1.5), h + 0.1], center = true);
		translate([0,0,0]) rotate([90, 0, 0])
			cylinder(h = 2 * r + 3.2, r = screwHoleR, $fn = 100, center = true);
	}
	
}

module holder(h, r) {
	difference()
	{
		cylinder(h = h, r = r + 1.5, $fn = 100, center = true);
		cylinder(h = h + 0.1, r = r, $fn = 100, center = true);
		
	}
}

module armholder(h, r) {
	difference()
	{
		translate([ringR + 4.5, 0, 0])
			cube(size = [ r + 3 , r * 2, h], center = true);
		translate([ringR + 3 + armholderR, 0, 0])
			cube(size = [ 2 * r, 2 * r + 0.1, h - 6], center = true);
		translate([ringR + 3 + armholderR, 0, 0])
			cylinder(h = h + 0.1, r = screwHoleR, $fn = 100, center = true);
	}

	translate([ringR + 3 + armholderR, 0, 0]) difference()
	{
		cylinder(h = h, r = r, $fn = 100, center = true);
		cylinder(h = h + 0.1, r = screwHoleR, $fn = 100, center = true);
		cylinder(h = h - 6, r = r + 0.05, $fn = 100, center = true);
		
	}

}

module doorholder (h, r) {
	difference()
	{
		translate([0, 0, h]) scale ([1.15, 1, 1]) rotate([90, 0, 0]) 
			rotate_extrude(convexity = 10, $fn = 100)
				translate([h, 0, 0]) 
					circle(r = r, $fn = 100);
		cylinder(h = h + 2 + 0.1, r = screwHoleR, $fn = 100, center = true);
	}
	//PLatform
	difference()
	{
		translate([0, 0, h/6])
			cylinder(h = h * 0.9, r = h + 1, $fn = 100, center = true);
		cylinder(h = h * 2 + 0.1, r = screwHoleR + 0.04, $fn = 100, center = true);
	}
	
}

//Create

union()
{
	halfaring(ringH, ringR);
	translate([0, ringR - holderR/2, 0]) rotate([90, 0, 0])
		holder(holderH, holderR);
	mirror([0,1,0]) translate([0, ringR - holderR/2, 0]) rotate([90, 0, 0])
		holder(holderH, holderR);
	armholder(armholderH, armholderR);
		//doorholder(6, 1.5);

}

