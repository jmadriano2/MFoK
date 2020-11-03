<template>
  <nav id="sidebar" v-bind:class="{ hide: !sidebarActive }">
    <div class="sidebar-header">
      <h3>Midas Fountain</h3>
      <h3>of Knowledge</h3>
    </div>

    <ul class="list-unstyled components">
      <p>Functions</p>
      <li class="active">
        <a
          href="#homeSubmenu"
          data-toggle="collapse"
          aria-expanded="false"
          class="dropdown-toggle"
          >Home</a
        >
        <ul class="collapse list-unstyled" id="homeSubmenu">
          <li>
            <a href="#">Home 1</a>
          </li>
          <li>
            <a href="#">Home 2</a>
          </li>
          <li>
            <a href="#">Home 3</a>
          </li>
        </ul>
      </li>
      <li>
        <a href="#">About</a>
      </li>
      <li>
        <a
          href="#pageSubmenu"
          data-toggle="collapse"
          aria-expanded="false"
          class="dropdown-toggle"
          >Pages</a
        >
        <ul class="collapse list-unstyled" id="pageSubmenu">
          <li>
            <a href="#">Page 1</a>
          </li>
          <li>
            <a href="#">Page 2</a>
          </li>
          <li>
            <a href="#">Page 3</a>
          </li>
        </ul>
      </li>
      <li>
        <a href="#">Portfolio</a>
      </li>
      <li>
        <a href="#">Contact</a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  props: ["sidebarActive"],
};
</script>

<style scoped>
@import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";

#sidebar {
  min-width: 250px;
  max-width: 250px;
  min-height: 100vh;
  background: #7386d5;
  color: #fff;
  transition: all 0.3s;
}

#sidebar.hide {
  margin-left: -250px;
}

@media (max-width: 768px) {
  #sidebar {
    margin-left: -250px;
    background: #7386d5;
    color: #fff;
    transition: all 0.3s;
  }
  #sidebar.hide {
    margin-left: 0;
  }
}

.sidebar-header {
    text-align: center;
}

a[data-toggle="collapse"] {
  position: relative;
}

.dropdown-toggle::after {
  display: block;
  position: absolute;
  top: 50%;
  right: 20px;
  transform: translateY(-50%);
}

body {
  font-family: "Poppins", sans-serif;
  background: #fafafa;
}

p {
  font-family: "Poppins", sans-serif;
  font-size: 1.1em;
  font-weight: 300;
  line-height: 1.7em;
  color: #999;
}

a,
a:hover,
a:focus {
  color: inherit;
  text-decoration: none;
  transition: all 0.3s;
}

#sidebar ul.components {
  padding: 20px 0;
  border-bottom: 1px solid #47748b;
}

#sidebar ul p {
  color: #fff;
  padding: 10px;
}

#sidebar ul li a {
  padding: 10px;
  font-size: 1.1em;
  display: block;
}
#sidebar ul li a:hover {
  color: #7386d5;
  background: #fff;
}

#sidebar ul li.active > a,
a[aria-expanded="true"] {
  color: #fff;
  background: #6d7fcc;
}
ul ul a {
  font-size: 0.9em !important;
  padding-left: 30px !important;
  background: #6d7fcc;
}
</style>