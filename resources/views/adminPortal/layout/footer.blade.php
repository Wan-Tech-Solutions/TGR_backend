<footer class="footer">
    <div class="container-fluid d-flex justify-content-between">
      <nav class="pull-left">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="#">
              Need Help?
            </a>
          </li>
        </ul>
      </nav>
      <div class="copyright">
        Developed by
        <a href="https://wantechsolutions.com">WanTech Solutions</a>
      </div>
      <div>
        Copyright
        <a href="#">&copy {{ now()->year }}</a>.
      </div>
    </div>
  </footer>
</div>
</div>
<!--   Core JS Files   -->
<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

<!-- jQuery Scrollbar -->
<script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

<!-- Chart JS -->
<script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>

<!-- jQuery Sparkline -->
<script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

<!-- Chart Circle -->
<script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>

<!-- Datatables -->
<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>

<!-- Bootstrap Notify -->
<script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

<!-- jQuery Vector Maps -->
<script src="{{ asset('assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/jsvectormap/world.js') }}"></script>

<!-- Sweet Alert -->
<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Kaiadmin JS -->
<script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>

<!-- Optional demo scripts removed to keep bundle lean -->
<script>
$("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
  type: "line",
  height: "70",
  width: "100%",
  lineWidth: "2",
  lineColor: "#177dff",
  fillColor: "rgba(23, 125, 255, 0.14)",
});

$("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
  type: "line",
  height: "70",
  width: "100%",
  lineWidth: "2",
  lineColor: "#f3545d",
  fillColor: "rgba(243, 84, 93, .14)",
});

$("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
  type: "line",
  height: "70",
  width: "100%",
  lineWidth: "2",
  lineColor: "#ffa534",
  fillColor: "rgba(255, 165, 52, .14)",
});
</script>

<script>
  $(document).ready(function () {
    $("#basic-datatables").DataTable({});

    $("#multi-filter-select").DataTable({
      pageLength: 5,
      initComplete: function () {
        this.api()
          .columns()
          .every(function () {
            var column = this;
            var select = $(
              '<select class="form-select"><option value=""></option></select>'
            )
              .appendTo($(column.footer()).empty())
              .on("change", function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());

                column
                  .search(val ? "^" + val + "$" : "", true, false)
                  .draw();
              });

            column
              .data()
              .unique()
              .sort()
              .each(function (d, j) {
                select.append(
                  '<option value="' + d + '">' + d + "</option>"
                );
              });
          });
      },
    });

    // Add Row
    $("#add-row").DataTable({
      pageLength: 5,
    });

    var action =
      '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

    $("#addRowButton").click(function () {
      $("#add-row")
        .dataTable()
        .fnAddData([
          $("#addName").val(),
          $("#addPosition").val(),
          $("#addOffice").val(),
          action,
        ]);
      $("#addRowModal").modal("hide");
    });
  });
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
  const origin = location.origin;
  const currentPath = (location.pathname || '/').replace(/\/+$/, '') || '/';

  function hrefToPath(href) {
    try {
      const url = new URL(href, origin);
      return (url.pathname || '/').replace(/\/+$/, '') || '/';
    } catch (e) {
      return (href || '').replace(/\/+$/, '') || '/';
    }
  }

  // Reset previous states
  document.querySelectorAll('.sidebar .nav-item.active').forEach(el => el.classList.remove('active'));
  document.querySelectorAll('.sidebar .nav-collapse a.active').forEach(el => el.classList.remove('active'));
  document.querySelectorAll('.sidebar .collapse.show').forEach(el => el.classList.remove('show'));
  document.querySelectorAll('.sidebar .nav-item.open-toggle').forEach(el => el.classList.remove('open-toggle'));
  document.querySelectorAll('.sidebar .nav-section.active-section').forEach(el => el.classList.remove('active-section'));
  document.querySelectorAll('.sidebar [data-bs-toggle="collapse"]').forEach(toggle => {
    toggle.setAttribute('aria-expanded', 'false');
  });

  // helper to find nearest previous .nav-section sibling
  function findSectionFor(el) {
    let current = el;
    // walk up until root of sidebar-content or body
    while (current && !current.classList?.contains('sidebar-content')) {
      // if we find a nav-section as a previous sibling of any ancestor, return it
      let prev = current.previousElementSibling;
      while (prev) {
        if (prev.classList.contains('nav-section')) return prev;
        prev = prev.previousElementSibling;
      }
      current = current.parentElement;
    }
    return null;
  }

  // 1) handle nested submenu links (inside collapses)
  const nestedLinks = document.querySelectorAll('.sidebar .nav-collapse a[href]');
  nestedLinks.forEach(link => {
    const linkPath = hrefToPath(link.getAttribute('href'));
    const isActive = (currentPath === linkPath) || currentPath.startsWith(linkPath + '/');

    if (isActive) {
      // mark the sub-link
      link.classList.add('active');

      // highlight its containing section (if any)
      const section = findSectionFor(link.closest('.nav-collapse, .collapse'));
      if (section) section.classList.add('active-section');

      // open the collapse container
      const collapseEl = link.closest('.collapse');
      if (collapseEl) {
        collapseEl.classList.add('show');

        // identify the toggle that controls this collapse
        const collapseId = collapseEl.id ? ('#' + collapseEl.id) : null;
        let toggle = null;
        if (collapseId) {
          toggle = document.querySelector(
            '.sidebar [data-bs-toggle="collapse"][href="' + collapseId + '"], ' +
            '.sidebar [data-bs-toggle="collapse"][data-bs-target="' + collapseId + '"]'
          );
        }
        // fallback: try to find a sibling toggle in ancestor li
        if (!toggle) {
          const liWithCollapse = collapseEl.closest('li.nav-item');
          if (liWithCollapse) toggle = liWithCollapse.querySelector('[data-bs-toggle="collapse"]');
        }

        if (toggle) {
          toggle.setAttribute('aria-expanded', 'true');
          const parentNavItem = toggle.closest('li.nav-item');
          if (parentNavItem) {
            parentNavItem.classList.add('active');
            parentNavItem.classList.add('open-toggle'); // for caret rotate
          }

          // mark the section for the toggle too (helps for toggles placed in different spots)
          const sectionForToggle = findSectionFor(toggle);
          if (sectionForToggle) sectionForToggle.classList.add('active-section');
        } else {
          // no toggle found: mark the closest li.nav-item
          const liWithCollapse = collapseEl.closest('li.nav-item');
          if (liWithCollapse) liWithCollapse.classList.add('active');
        }
      }
    }
  });

  // 2) handle top-level nav items
  const directLinks = document.querySelectorAll('.sidebar .nav-secondary > .nav-item > a[href]');
  directLinks.forEach(link => {
    const linkPath = hrefToPath(link.getAttribute('href'));
    const isActive = (currentPath === linkPath) || currentPath.startsWith(linkPath + '/');
    const parentLi = link.closest('li.nav-item');

    if (isActive) {
      if (parentLi) parentLi.classList.add('active');
      link.classList.add('active');

      // section highlight for top-level item
      const section = findSectionFor(parentLi);
      if (section) section.classList.add('active-section');
    }
  });

  // 3) If multiple top-level parents were opened, keep the one with visible active child; otherwise keep first
  // (No extra code needed here as logic above marks only matching parents.)

  // (Optional) Ensure only ONE nav-section remains active (clean up extras)
  const activeSections = Array.from(document.querySelectorAll('.sidebar .nav-section.active-section'));
  if (activeSections.length > 1) {
    // keep the closest one to active link(s) if possible
    const first = activeSections[0];
    activeSections.forEach((s, idx) => { if (idx !== 0) s.classList.remove('active-section'); });
  }
});
</script>

@stack('page-scripts')

</body>
</html>
