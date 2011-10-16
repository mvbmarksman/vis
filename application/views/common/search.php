<style>

#search {
	width: 190px;
	margin: 7px auto;
	border: 1px solid silver;
	border-top: none;
	font-size: 12px;
}
#search h1 {
	background: #6997BF;
	color: #fff;
	padding: 5px;
	width: 181px;
}

#search input {
	font-size: 11px;
	float: left;
	width: 159px;
	height: 16px;
	border: 1px solid #8EA7D1;
	margin-top: 1px;
}

#searchbox {
	padding: 5px 5px 23px 5px;
}

#searchIcon {
	background-image: url("/public/images/icons/magnifier.png");
	height:16px;
	width: 16px;
	float: right;
	border: 1px solid #8EA7D1;
	margin-top: 1px;
	cursor: pointer;
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
