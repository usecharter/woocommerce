<?php

// Add admin page and settings.
function charter_add_admin_page(): void {
	add_menu_page(
		'Charter',
		'Charter',
		'manage_options',
		'charter',
		'charter_admin_page',
		'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCA1NTUgNTU2IiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgogICAgPGcgY2xpcC1wYXRoPSJ1cmwoI2NsaXAwXzI2NV8xNzMwKSI+CiAgICAgICAgPHBhdGggZD0iTTM5LjkzNjUgMTg5LjQyNkw0ODMuMzI1IDcwLjYyMDhDNDk4LjI0NSA2Ni4yMzEyIDUyNi4yMiA2Mi40MDg5IDU0NS41MTYgNzEuNDQ1QzU2MS4zNCA3OC44NTUzIDU0NS4yNTUgOTUuNTQ4NiA1MTguOTYxIDEwNy43MDhMMjQ5Ljg1IDIyNS40NzNDMTkyLjExNiAyNTQuNTY0IDE0Ni41MjEgMjYxLjgyOCAxNDkuMTYyIDMyOS4yMjhDMTU1Ljc2MyA0OTcuNjc1IDE1My43MjYgNTE2LjQ3OSAxMTIuODA1IDQ2MS4zNzZDODAuNjQ1MSA0MDMuOTI2IDEzLjk5MzEgMjgwLjMyMiA0LjY2NTkzIDI0NS41MTNDLTQuNjYxMjYgMjEwLjcwMyAyNC4yOTM0IDE5My42MTggMzkuOTM2NSAxODkuNDI2WiIgZmlsbD0iIzlDQTJBNyIvPgogICAgPC9nPgo8L3N2Zz4K',
		58
	);
}
add_action('admin_menu', 'charter_add_admin_page');
