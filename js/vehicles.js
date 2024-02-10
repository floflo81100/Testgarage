// js/vehicle.js

document.addEventListener('DOMContentLoaded', () => {
    // Initialiser Isotope
    var iso = new Isotope('#vehicles', {
        itemSelector: '.vehicle-card',
        layoutMode: 'fitRows'
    });

    // Filtres
    const filterMake = document.getElementById('filterMake');
    const filterModel = document.getElementById('filterModel');
    const filterFuel = document.getElementById('filterFuel');
    const filterPrice = document.getElementById('filterPrice');
    const filterMileage = document.getElementById('filterMileage');

    function filterVehicles() {
        let filterValue = '';
        
        filterValue += filterMake.value ? `[data-make="${filterMake.value}"]` : '';
        filterValue += filterModel.value ? `[data-model="${filterModel.value}"]` : '';
        filterValue += filterFuel.value ? `[data-fuel="${filterFuel.value}"]` : '';

        if (filterPrice.value || filterMileage.value) {
            iso.arrange({
                filter: function(itemElem) {
                    const price = parseFloat(itemElem.getAttribute('data-price'));
                    const mileage = parseFloat(itemElem.getAttribute('data-mileage'));
                    return (!filterPrice.value || price <= parseFloat(filterPrice.value)) && 
                           (!filterMileage.value || mileage <= parseFloat(filterMileage.value));
                }
            });
        } else {
            iso.arrange({ filter: filterValue });
        }
    }

    filterMake.addEventListener('change', filterVehicles);
    filterModel.addEventListener('change', filterVehicles);
    filterFuel.addEventListener('change', filterVehicles);
    filterPrice.addEventListener('change', filterVehicles);
    filterMileage.addEventListener('change', filterVehicles);
});
