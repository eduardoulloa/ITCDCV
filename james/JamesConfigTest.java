public class JamesConfigTest
{
  public static void main(String[] args)
    throws Exception
  {
    // CREATE CLIENT INSTANCES
    MailClient redClient = new MailClient("red", "localhost");
    MailClient greenClient = new MailClient("green", "localhost");
    MailClient blueClient = new MailClient("blue", "localhost");
    
    // CLEAR EVERYBODY'S INBOX
    //redClient.checkInbox(MailClient.CLEAR_MESSAGES);
    //greenClient.checkInbox(MailClient.CLEAR_MESSAGES);
    //blueClient.checkInbox(MailClient.CLEAR_MESSAGES);
    Thread.sleep(500); // Let the server catch up
    
    // SEND A COUPLE OF MESSAGES TO BLUE (FROM RED AND GREEN)
    /*redClient.sendMessage(
      "ulloamagallanes@gmail.com",
      "Testing blue from red",
      "Good Morning sir, it's a pleasure! Nice to meet u, i was starting to consider that u should work for us! give it a try.");
    */
    Thread.sleep(500); // Let the server catch up
    
    // LIST MESSAGES FOR BLUE (EXPECT MESSAGES FROM RED AND GREEN)
    blueClient.checkInbox(MailClient.SHOW_AND_CLEAR);
  }
}
