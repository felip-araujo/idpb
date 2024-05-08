<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap Notification</title>
  <!-- Adicione o CSS do Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Estilo para a notificação flutuante no canto inferior direito */
    .floating-alerts {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 9999;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <!-- Container para notificações flutuantes -->
  <div class="floating-alerts"></div>
</div>

<!-- Adicione os scripts do Bootstrap e do jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  // Função para exibir notificações flutuantes
  function showNotification(message, type) {
    var alertClass = 'alert-' + type;
    var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">'
                   + message
                   + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                   + '</div>';
    $('.floating-alerts').append(alertHtml);
    $('.floating-alerts .alert').last().alert();
  }

  // Exemplo de uso
  showNotification('Sua mensagem foi enviada com sucesso.', 'success');
</script>
</body>
</html>
