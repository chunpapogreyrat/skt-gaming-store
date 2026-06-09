{{-- JS khu admin: Bootstrap bundle + toggle sidebar mobile --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function () {
        document.getElementById('adminSidebar').classList.toggle('is-open');
    });
</script>

@stack('scripts')
