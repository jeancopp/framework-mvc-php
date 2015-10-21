    $(document).ready(function () {
        $("#gerar_models").click(function (e) {
            e.preventDefault();

            var count = 0;
            $(".has-checkbox").find('input').each(function (index, item) {
                if (item.checked) count++;
            });

            if (count > 0) {
                // Pode enviar os dados
                return true;
            } else {
                alert("Seleciona alguma coisa imediatamente");
                return false;
            }
        });
    });
