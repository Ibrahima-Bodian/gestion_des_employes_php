<nav class="site-menu" aria-label="Menu principal">
  <h2>Menu</h2>
  <ul class="menu-list">
    <li><a href="/TP3Web/pages/formulaire.php">2. Affichage des employés par département</a></li>
    <li><a href="/TP3Web/pages/formulaireDeptSalaireMin.php">4. Affichage par département + salaire minimal</a></li>
    <li><a href="/TP3Web/pages/formulaireDeptSalaireMin.php">5. Infos chef & département</a></li>
    <li><a href="/TP3Web/pages/formulaire.php">6. Affichage par nom de département</a></li>
    <li><a href="/TP3Web/pages/saisie.php">7. Saisie d'un nouvel employé</a></li>
    <li><a href="/TP3Web/pages/choixEmploye.php">8. Changement de chef</a></li>
    <li><a href="/TP3Web/pages/suppressionEmploye.php">9. Suppression d'un employé</a></li>
    <li><a href="/TP3Web/pages/filtreEmployeDept.php">10. Filtrage par département</a></li>
    <li>
      11. Visualisation des salaires
      <ul class="submenu">
        <li><a href="/TP3Web/pages/barchart.php">a. BarChart</a></li>
        <li><a href="/TP3Web/pages/linechart.php">b. LineChart</a></li>
        <li><a href="/TP3Web/pages/piechart.php">c. PieChart</a></li>
      </ul>
    </li>
  </ul>
</nav>

<style>
.site-menu { background:#f8f9fb; padding:1rem; border-radius:6px; box-shadow:0 1px 4px rgba(0,0,0,0.06); }
.site-menu h2 { margin:0 0 .5rem 0; font-size:1.1rem; color:#333; }
.menu-list { list-style:none; padding:0; margin:0; }
.menu-list > li { padding:.35rem 0; border-bottom:1px dashed #e6e9ef; }
.menu-list > li:last-child { border-bottom:0; }
.menu-list a { color:#0a58ca; text-decoration:none; font-weight:600; }
.menu-list a:hover { text-decoration:underline; }
.submenu { list-style:none; margin:.4rem 0 0 0.8rem; padding:0; }
.submenu li { padding:.15rem 0; font-weight:400; }
</style>