<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Confirmation de Paiement</title>
</head>
<style>* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

body {
  font-family: 'Inter', sans-serif;
  background-color:#f8f8ff;
  color: #333;
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.container {
  width: 100%;
  max-width: 600px;
  background-color: #ffffff;
  border-radius: 16px;
  padding: 40px 30px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
  text-align: center;
}

.icon-circle {
  background-color: #e1f7e6;
  color: #27ae60;
  font-size: 36px;
  width: 80px;
  height: 80px;
  margin: 0 auto 20px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

h1 {
  font-size: 28px;
  font-weight: 600;
  color: #27ae60;
  margin-bottom: 16px;
}

.message {
  font-size: 16px;
  margin-bottom: 16px;
}

.tool-info {
  font-size: 15px;
  color: #2563eb;
  margin: 20px 0;
}

.tool-info .highlight {
  font-weight: 600;
  color: #2c3e50;
}

.contact {
  font-size: 14px;
  color: #666;
  margin-top: 20px;
}

.contact a {
  color: #333;
  text-decoration: underline;
  font-weight: 500;
}

.button-container {
  margin-top: 30px;
}

.button {
  display: inline-block;
  background-color: #333;
  color: #fff;
  padding: 12px 24px;
  border-radius: 30px;
  font-size: 15px;
  text-decoration: none;
  transition: background 0.3s ease, transform 0.2s ease;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.button:hover {
  background-color: #555;
  transform: scale(1.05);
}

</style>
<body>
  <div class="container">
    <div class="card">
      <div class="icon-circle"></div>
      <h1>Paiement réussi !</h1>
      <p class="message">Merci pour votre réservation.</p>
      <p class="tool-info">
        <span class="highlight">Vous recevrez bientôt votre produit.</span>
      </p>
      <div class="button-container">
        <a href="index.php" class="button">Retour à l'accueil</a>
      </div>
    </div>
  </div>
</body>
</html>
 