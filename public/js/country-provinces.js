    /*
     * @province <select> element with opgtroups of provinces separated by country
     * @country  <select> element
     */
    function countryProvinces(province, country)
    {
        //zf2 select options dont allow non-standard attributes.. hooray.
        opts = $(province).children('optgroup').each(function(){
            $(this).attr('data-country_code', $(this).children().val().substring(0,2));
        });
        $(province).data('options', opts);
        $(country).data('province', province);

        updateProvince = function(province, countryCode) {
            $(province).val(0)
            $(province).children('optgroup').remove();
            $(province).data('options').each(function(){
                if ($(this).data('country_code') == countryCode) {
                    $(province).append(this);
                }
            })
        }
        //on change of country, update province element to show provinces that match the country
        $(country).change(function() {
            updateProvince($(this).data('province'), $(this).val());
        });

        selectedProvince = $(province).val();
        updateProvince(province, $(country).val());
        $(province).val(selectedProvince);
    }
