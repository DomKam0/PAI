<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<style type="text/css">
		ul#menu {
			float: left;
			width: 10%;
			list-style-type: none;
		}

		div#tresc {
			float: left;
			width: 85%;
		}
		p {
		background-color:<?php echo $_SESSION["SelectedColor"]?>;
		font-family :<?php echo $_SESSION["SelectedFont"]?>;
		font-size :<?php echo $_SESSION["SelectedFontSize"]?>px;
		}
	</style>
</head>

<body>
	<ul id="menu">
		<li><a href="tekst.php">Tekst</a></li>
		<li><a href="ustawienia.php">Ustawienia</a></li>
	</ul>
	<div id="tresc">
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed viverra dui ac ipsum aliquet iaculis. Quisque ac
			neque nisi. Curabitur vulputate, dui ut congue molestie, leo enim dapibus lacus, a scelerisque quam tellus
			sit amet magna. Mauris a orci tellus, non facilisis nibh. In porta elit quis dolor elementum congue. Cum
			sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse potenti. Duis
			faucibus tincidunt tellus, rhoncus facilisis nibh tincidunt ac. Integer lacinia magna in lacus scelerisque
			pellentesque. Nam congue auctor urna. Vivamus vulputate lacus ut sapien laoreet hendrerit. Maecenas at ante
			velit. Etiam ligula nisl, pretium vel viverra at, fermentum sed sapien. Cras ligula ipsum, ultrices non
			congue eu, aliquam sit amet nisl. Sed tempus pharetra elit id fermentum. Nullam semper libero vitae elit
			fermentum euismod scelerisque ligula tempus. Vestibulum non ullamcorper est. Donec sit amet varius odio.
			Nulla dapibus sollicitudin velit nec varius. Nunc bibendum volutpat diam id accumsan.</p>

		<p>Aliquam elementum lobortis diam eu malesuada. Vivamus facilisis metus non tellus accumsan ultrices. Morbi in
			orci ante. Nulla auctor dictum ipsum, a varius sapien suscipit in. Integer lacinia, dui a ultrices posuere,
			sem nunc condimentum nunc, eget ullamcorper felis libero id elit. Etiam tempor feugiat sem, in semper tellus
			tempor eu. Aliquam ullamcorper pulvinar nisi et scelerisque. Nullam aliquam arcu et sem mattis nec gravida
			turpis viverra. Suspendisse a lobortis quam. Maecenas dictum, tellus eget vehicula consequat, est ipsum
			fringilla lorem, non blandit justo justo vitae felis. Curabitur pellentesque sodales risus, et aliquet erat
			porta et. Donec accumsan enim in turpis ultricies iaculis.</p>

		<p>Donec tempus sollicitudin nulla, vulputate pulvinar augue venenatis ut. Nullam scelerisque diam eget felis
			rhoncus non tempus sem consequat. Ut eleifend, lacus nec porta ultrices, odio sapien rhoncus nibh, eget
			commodo ligula erat a quam. Nulla dui nunc, vehicula eget condimentum et, blandit non arcu. Integer rhoncus
			eros ut leo tincidunt et tincidunt purus accumsan. Sed auctor ultricies quam ut fringilla. Quisque eget
			sapien massa, vitae aliquet ligula. Cras cursus convallis tellus quis rhoncus. In lectus turpis, interdum
			vel pellentesque molestie, suscipit eu nulla. Sed posuere massa at lacus scelerisque vel tempor risus
			semper. Nulla semper, leo sed dapibus aliquet, purus nisi pulvinar nisi, sed lacinia felis diam fringilla
			lacus. Donec at ipsum eros, nec pulvinar orci. Curabitur congue vulputate libero quis fringilla. Sed
			faucibus pharetra sapien porttitor fringilla. Proin ut sapien ac urna accumsan cursus. Nulla enim nisl,
			condimentum sit amet tempus at, vulputate non urna. Proin nec posuere arcu. Morbi elementum elit ligula.
		</p>
	</div>
</body>

</html>