<style>

#search {
	width: 190px;
	margin: 7px auto;
	border: 1px solid silver;
	border-top: none;
	font-size: 14px;
}
#search h1 {
	background: #6997BF;
	color: #fff;	
	padding: 5px;
}

#search input {
	font-size: 11px;
	float: left;
}

#searchbox {
	padding: 5px 5px 23px 5px;
}
#searchIcon {
	background-image: url("/public/images/icons/magnifier.png");
	height:16px;
	width: 16px;
	float:left;
	border: 1px solid #8EA7D1;
	margin-left: -1px;
	cursor: pointer;
}

#searchContainer {
	margin-left: 2px;
}
</style>

<div id="search">
	<h1>Search</h1>
	<div id = "searchbox">
		<div id="searchContainer">
			<input type="text"/><div id="searchIcon"></div>
		</div>
	</div>
</div>
