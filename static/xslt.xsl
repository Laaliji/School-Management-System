<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <!-- Identity template to copy content as is -->
    <xsl:template match="@*|node()">
        <xsl:copy>
            <xsl:apply-templates select="@*|node()"/>
        </xsl:copy>
    </xsl:template>

    <!-- Customize the appearance of the table -->
    <xsl:template match="h1[contains(@class, 'h3')]/strong">
        <h1>
            <xsl:apply-templates/>
        </h1>
    </xsl:template>

    <!-- Customize the appearance of the table -->
    <xsl:template match="div[contains(@class, 'card-header')]">
        <h5 class="card-header">
            <xsl:apply-templates/>
        </h5>
    </xsl:template>

    <!-- Adjust the table structure and style -->
    <xsl:template match="div[contains(@class, 'table-responsive')]">
        <div class="table-container">
            <table class="table">
                <thead style="background-color: #f8f9fe;">
                    <xsl:apply-templates select="thead"/>
                </thead>
                <tbody>
                    <xsl:apply-templates select="tbody/tr"/>
                </tbody>
            </table>
        </div>
    </xsl:template>

    <!-- Adjust the appearance of the table headers -->
    <xsl:template match="thead">
        <xsl:apply-templates/>
    </xsl:template>

    <!-- Customize the appearance of the table rows -->
    <xsl:template match="tbody/tr">
        <tr style="background-color: #ffffff;">
            <xsl:apply-templates/>
        </tr>
    </xsl:template>

    <!-- Customize the appearance of the form -->
    <xsl:template match="form[contains(@class, 'update-mark-form')]">
        <form class="update-mark-form" action="" method="post" style="display: flex; gap: 5px; margin-bottom: 10px;">
            <xsl:apply-templates/>
        </form>
    </xsl:template>

    <!-- Customize the appearance of the form elements -->
    <xsl:template match="input[contains(@type, 'text')]">
        <input type="text" name="updated_mark" placeholder="Changer la note" style="padding: 5px;"/>
    </xsl:template>

    <xsl:template match="button[contains(@type, 'submit')]">
        <button type="submit" style="padding: 5px 10px; background-color: green; color: #fff; border: none; cursor: pointer;">
            <xsl:apply-templates/>
        </button>
    </xsl:template>

    <!-- Example of using XPath to filter students with a mark greater than 15 -->
    <xsl:template match="tbody/tr[td[11] &gt; 15]">
        <xsl:apply-templates/>
    </xsl:template>

</xsl:stylesheet>
