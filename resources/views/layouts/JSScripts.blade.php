<script>
    function redirectToEquipmentStatus(id) {
        window.location.href = `{{ route('showEquipmentStatus') }}?id=${id}`;
    }

    const equipmentControls = document.getElementsByClassName('EquipmentControl');
    Array.from(equipmentControls).forEach(element => {
        element.onclick = function () {
            const id = element.getAttribute('data-id');
            redirectToEquipmentStatus(id);
        };
    });
</script>
