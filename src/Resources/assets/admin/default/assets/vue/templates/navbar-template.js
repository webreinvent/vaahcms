const NavbarTemplate = `<nav>

<ul>
  <li>
  <router-link :to="{ path: '/'}" replace>Home</router-link>
  </li>
  <li>
  <router-link :to="{ path: '/about'}" replace>About</router-link>
  
  </li>
</ul>

</nav>`

export { NavbarTemplate }