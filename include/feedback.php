<link rel="stylesheet" href="../css/chat.css">
    
<input type="checkbox" id="click">
<label for="click">
  <i class="fab fa-facebook-messenger"></i>
  <i class="fas fa-times"></i>
</label>
<div class="wrapper">
  <div class="head-text">
    Feedback
  </div>
  <div class="chat-box">
    <div class="desc-text">
      Mesajul dumneavoastră este important pentru noi ! 
    </div>
    <div id="confirmation-message" class="confirmation-message" style="display: none;">
            Mesajul a fost trimis cu succes!
    </div>
    <form action="submit_feedback.php" method="post">
      <div class="field">
        <input type="text" name="nume" placeholder="Numele dumneavoastră" required>
      </div>
      <div class="field">
        <input type="email" name="email" placeholder="Email-ul" required>
      </div> 
      <div class="field">
        <input type="text" name="mesaj" placeholder="Mesajul!" required>
      </div>
      <div class="field">
        <input type="submit" class="btn btn-outline-success" value="Trimite">
      </div>
    </form>
  </div>
</div>
