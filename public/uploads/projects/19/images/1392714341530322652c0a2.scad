//Variables
hingeR = 4;
platformL = 18;
platformW = 2 * hingeR;
platformH = platformL/3;
screwHoleR = 0.8;
screwHoleH = platformH/3;
//hingeH = platformH;
doorhingeW = platformL * 0.6;

//Modules
module hingeplatform(l, w, h, r) {
	difference()
	{
		cube(size = [l, w, h], center = true);
		translate([platformL/4, 0, -platformH/2])
			cylinder(h = screwHoleH, r = screwHoleR, $fn = 100, center = true);
		mirror([-1, 0, 0]) translate([platformL/4, 0, -platformH/2])
			cylinder(h = screwHoleH, r = screwHoleR, $fn = 100, center = true);
		translate([0, 0, platformH/2]) rotate([0, 90, 0])
			cylinder(h = l + 0.1, r = r/2, $fn = 100, center = true);

	}
	difference()
	{
		union()
		{
			translate([0, 0, platformH/2]) rotate([0, 90, 0])
			cylinder(h = l, r = r, $fn = 100, center = true);
			translate([platformL/2, 0, platformH/2]) 
			sphere(r = r, $fn = 100);
		}
		translate([0, 0, platformH/2]) rotate([0, 90, 0])
			cylinder(h = l + 0.1, r = r/2, $fn = 100, center = true);
	}
}

module doorhinge(l, w, h, r) {
	difference()
	{
		translate([0, -w/2, -r * 0.75])
			cube(size = [l, w, r/2], center = true);
		translate([platformL/4, -w * 0.75, -platformH/2])
			cylinder(h = h, r = screwHoleR, $fn = 100, center = true);
		mirror([-1, 0, 0]) translate([platformL/4, -w * 0.75, -platformH/2])
			cylinder(h = h, r = screwHoleR, $fn = 100, center = true);
		rotate([0, 90, 0])
			cylinder(h = l + 0.1, r = r/2 + 0.02, $fn = 100, center = true);
	}

	difference()
	{
		rotate([0, 90, 0])
			cylinder(h = l, r = r, $fn = 100, center = true);
		rotate([0, 90, 0])
			cylinder(h = l + 0.1, r = r/2 + 0.02, $fn = 100, center = true);
	}
	difference()
	{
		mirror([-1, 0, 0]) translate([platformL/2, 0, 0]) 
			sphere(r = r, $fn = 100);
		rotate([0, 90, 0])
			cylinder(h = l + 0.1, r = r/2 + 0.02, $fn = 100, center = true);
	}
}

//Create 
/*rotate([0, -90, 0])
union()
{
	hingeplatform(platformL, platformW, platformH, hingeR);
}*/

translate([2.5, 0, platformL]) rotate([0, 90, 0])
union()
{
	mirror([0, 1, 0]) doorhinge(platformL, doorhingeW, platformH, hingeR);
}