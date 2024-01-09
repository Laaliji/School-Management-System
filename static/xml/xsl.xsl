<!-- Assuming you have a server-side script (e.g., PHP) to handle authentication -->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

  <xsl:template match="/">
    <html>
      <head>
        <title>Authentication Form</title>
      </head>
      <body>
        <form action="authenticate.php" method="post">
          <label for="username">Username:</label>
          <input type="text" id="username" name="username" required/><br/>

          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required/><br/>

          <input type="submit" value="Login"/>
        </form>
      </body>
    </html>
  </xsl:template>

</xsl:stylesheet>
