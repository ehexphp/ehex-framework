<?php




/**
 * A Customisable Settings for every page. This model can contain the site
 * social network handles, email addresses, site phone numbers and so on.
 * This model settings does not save to database but instead to file system
 * directly as a file session. This can be manipulated "Model1PageInterface" methods.
 * Please read on Model1PageInterface in documentation. To manipulate and
 * Create similar class
 *
 *
 * This  also serve as a settings class for app theme layout.
 * It generate the settings to use for all layout.
 * You can edit this to suit your need.
 * Class FrontendPage
 */
class FrontendPage  extends Model1 implements Model1PageInterface {

    public $founder = '';
    public $about_company = "<p>OakTreeFinances is a leading investment firm with a proven track record of delivering consistent,
                            long-term results for our clients. Our team of experienced professionals includes financial analysts,
                            portfolio managers, and investment advisors who are dedicated to staying ahead of market trends and identifying
                            opportunities that can benefit our clients.</p>

                        <p>We facilitate the generation of substantial returns through real estate investments enabled by tokenization of
                            assets, alleviating the need for property visitations or assuming operational responsibilities. Our services
                            focus solely on optimizing your profits powered by A.I trading. We also ensure the security and effective
                            utilization of your 401k and retirement funds by strategically allocating them for long-term, profit-driven investments.</p>";

    public $footer_about_us = '';
    public $footer_terms = '';
    public $footer_privacy = Config1::APP_FANCY_TITLE.' will not in any way or form divulge information gathered during our investigations for our client to a third-party except it has the written consent of such client or required by law.';

    public $privacy_policy = '<p>This website does not share personal information with third parties nor do we store any information about your visit to this website other than to analyze and optimize your content and reading experience through the use of cookies.</p>
        <p>You can turn off the use of cookies at any time by changing your specific browser settings.</p>
        <p>We are not responsible for republished content from this Website on other Websites or websites without our permission.</p>
        <p>This privacy policy is subject to change without notice and was last updated on January 10, 2023. If you have any questions feel free to contact us</p>';

    public $user_access_demo = 2000;
    public $total_happy_customer_demo = 600;
    public $total_review_demo = 489;
    public $total_successful_project_demo = 486;


    // Contact Info
    public $contact_phone_number = '+1-810-317-5649';
    public $contact_address = 'OakTreeFinances Corp, Amphitheatre Parkway, Mountain View, California, 94043';
    public $contact_email = "support@OakTreeFinances.com";
    public $contact_work_hour = "mon-fri 10am-6pm support";

    // Social List
    public $social_facebook = '#https://facebook.com/OakTreeFinances';
    public $social_twitter = '#https://twitter.com/OakTreeFinances';
    public $social_google_plus = '#https://googleplus.com/OakTreeFinances';
    public $social_instagram = '#https://';
    public $social_pinterest= 'https://pinterest.com/OakTreeFinances';
    public $social_linked_in = '#';
    public $social_youtube= '#';
    public $social_github= '#';
    public $social_flickr= '#';
    public $rss_feed= '#';



    // FAQs
    public $faq1Title = 'What is the level of risk associated with investing in OakTreeFinances?';
    public $faq1Body = "The likelihood of losing your invested funds with OakTreeFinances is minimal. This is because the company's management effectively mitigates potential factors that could negatively impact your investment.";

    public $faq2Title = "Can you describe the company's core activities in simple terms?";
    public $faq2Body = "OakTree specializes in managing its clients' pooled funds, which are then invested in various sectors, including Real Estate, Oil Vessels, Stocks, and cryptocurrency exchanges. The goal is to generate daily profits through cryptocurrency fund operations.";

    public $faq3Title = "How does the company handle the creation of multiple accounts?";
    public $faq3Body = "OakTreeFinances takes a firm stance against investors creating multiple accounts. Such behavior is not supported, and it is likely that cooperation with such investors will be suspended.";


    public $faq4Title = "Prior to investing in your company, I would like to assess its actual business profitability.";
    public $faq4Body = "Investing with OakTreeFinances offers a distinctive opportunity for secure passive income and substantial career advancement. Based on the underlying principles of our investment offerings, you can expect to significantly increase your income with confidence.";

    // Reviews
    public $review1 = "They provide the best trading education ever without a doubt, I keep learning every day from their great content and support overtime . 
         That shows you how experienced their team is and would encourage everybody to start learning and trading with Oaktree investment group.";
    public $review1Name = "Hugh Joyner";

    public $review2 = "This is a very good company to invest in to earn some nice interest with your IRA/401k long term investment. Been using them for a few months, I have not faced any major issue since I started trading here. 
        They have one of the best customer support teams I have ever dealt with. The support team is always available and helped me with all the details, 
        from opening the account to financing my crypto IRA account, and what I liked the most is about their interest in the day-to-day growth in your investment portfolio .";
    public $review2Name = "Jamie Pendergras";

    public $review3 = "I totally recommend investing with Oaktree group. Definitely a good start for people who want to invest in cryptos, 
        both beginners and professionals, because of the stable conditions and variety of products. I believe it’s an easy-to-use terminal 
        that allows anyone with a phone or computer to become a trader.";
    public $review3Name = "Angela Haydens";

    public $review4 = "I have been a cryptocurrency trader for several years and I like to try different options when trading. Oaktree  was recommended to me by a colleague so 
        I decided to give it a try. In general, I found it to be a very intuitive platform, good charts to monitor assets and fast order executions. 
        I have nothing bad to say, I hope they keep improving.";
    public $review4Name = "Helmut Cole";

    public $review5 = "I have tried various trading bots in the past, but none of them have been as effective as Oaktree trading bots. Its advanced algorithms and real-time analysis have helped me make profitable trades.";
    public $review5Name = "Rodrigo Haynes";

    public $review6 = "I was very skeptical about the claims made by initially, but after my initial deposit and then using it for a few months, 
        I am amazed at the accuracy of its predictions and signals. OakTree crypto trading bot has saved me a lot of time and effort in analyzing market data. 
        Its advanced algorithms and real-time analysis have helped me make profitable trades. Also its user-friendly interface and automated trading features have made my life much easier.";
    public $review6Name = "Damon Silver";

    public $ai_trading = "<p>At OakTree we have bots and automated trading systems designed to assist people with trading in various financial markets, 
                        including stocks, cryptocurrencies, forex, and commodities. These trading bots are software programs that use predefined 
                        algorithms and strategies to execute trades on behalf of traders. They are built to analyze and monitor market data to know when 
                        to stop the loss when the value of cryptocurrency depreciates in the market, to identify potential opportunities, and execute trades 
                        based on predetermined criteria. </p>
                        
                        <p>These bots can execute trades much faster than human traders, which is crucial in fast-moving markets 
                        where prices can change rapidly. They are built to operate around the clock, allowing traders to take advantage of opportunities even 
                        when they are not actively monitoring the markets.</p>";

    public $tokenization = "<p>
                            Real estate tokenization is a process that involves representing ownership or investment in real estate assets using blockchain technology and digital tokens. In traditional real estate, ownership is typically divided into shares, and these shares are held by individual investors or entities. Tokenization takes this concept a step further by digitizing these ownership shares and representing them as tokens on a blockchain.
                        </p>

                        <p>
                            Here's how real estate tokenization works:
                        </p>

                        <p>
                            Asset Selection: A real estate property, whether it's a residential, commercial, or industrial property, is selected for tokenization.
                        </p>

                        <p>
                            Legal and Regulatory Compliance: The property undergoes legal and regulatory scrutiny to ensure that it can be tokenized according to the relevant laws and regulations in the jurisdiction.
                        </p>

                        <p>
                            Creation of Tokens: The ownership shares of the property are divided into digital tokens, with each token representing a fractional ownership in the property. For instance, if a property is divided into 100 tokens, owning one token might represent 1% ownership of the property.
                        </p>

                        <p>
                            Blockchain Implementation: The digital tokens are then issued and managed on a blockchain platform. The blockchain provides a transparent, immutable, and secure ledger to track ownership and transactions.
                        </p>

                        <p>
                            Investment Opportunities: Investors can purchase these tokens, allowing them to invest in real estate without having to buy an entire property. This democratizes real estate investing by reducing the barrier to entry.
                        </p>

                        <p>
                            Liquidity and Trading: One of the significant advantages of tokenization is increased liquidity. Traditional real estate investments can be illiquid, as selling a physical property can take time. However, tokenized real estate allows for easier and faster trading of ownership tokens on secondary markets, providing investors with more flexibility.
                        </p>

                        <p>
                            Transparency: Blockchain technology ensures transparency by providing a secure and publicly accessible record of ownership transfers, transactions, and historical data related to the property.
                        </p>

                        <p>
                            Dividends and Returns: Rental income or profits generated from the property can be distributed to token holders in proportion to their ownership. This can be automated through smart contracts.
                        </p>

                        <p>
                            Global Accessibility: Real estate tokenization can attract investors from around the world, as it eliminates geographical barriers and allows for cross-border investments.
                        </p>";

    public $crypto_401k_investment = "<p>Have you ever thought about exploring Crypto 401k investments? You have the opportunity to participate in Oak Tree 401k investment plans.</p>
                                    <p>These 401(k) plans are strategically crafted for long-term wealth accumulation and securing your retirement. Within these retirement plans, 
                                    you'll find a range of traditional investment options that have been trusted over the years.</p>";


    /**
     * Save Model Data on Page Update Call
     */
    static function processUpdatePage(){
        Session1::setStatusFrom(static::saveDefault($_POST)? ['Updated', 'Page Updated!', 'success']: ['Failed', 'Failed to Updated Page', 'error']);
    }


    /**
     * Edit Page Variable.
     * This help to maintain dynamic website page
     *   to Use on any web-page, add $frontendPage = FrontendPage::getDefault();
     *   and get model instant data through $frontendPage->variableName
     * e.g
     *  $frontendPage = FrontendPage::getDefault();
     *  echo $frontendPage->about_company;
     * @return HtmlForm1|mixed|Xcrud
     */
    static function manage(){
        return new Html1(function(){
            echo HtmlForm1::open(self::class.'@processUpdatePage()');
            echo self::getDefault()->form([], ['rss_feed'])->setFieldAttribute([
                    'footer_about_us,
                             footer_terms, 
                             footer_privacy,
                             privacy_policy,
                             '=>['type'=>'textarea', 'style'=>'height:300px;width:100%'],
                ])->render();
            echo HtmlForm1::close("Save Page");
        });
    }






    /**
     * Dashboard Logo
     * @return string
     */
    static function logoOnly(){ return asset('images/favicon.png'); }
    static function logoWithText(){ return asset('images/favicon_with_text.png'); }










    /************************************************************************************************************************
     *
     *  MENU
     *
     ************************************************************************************************************************/


    /**
     * Common Menu for layout "ignite_blog"
     * @return array
     */
    static function getMenuCommon(){
        $menuList = [];


        if(Auth1::isGuest()) $menuList = array_merge($menuList, [
            url('login')=>'Login',
            url('register')=>'Register',
            url('#break2')=>'<div style="border:1px solid silver"><!--break----> </div>',
            url('forgot_password')=>'Forgot Password',
            url('reset_password')=>'Reset Password',
            url('#break3')=>'<div style="border:1px solid silver"><!-- break---------> </div>',
        ]);
        else $menuList = array_merge($menuList, [
            url('/dashboard')=>'Dashboard',
            url('#break4')=>'<div style="border:1px solid silver"> <!-- break------> </div>',
            'http://ehex.xamtax.com'=>'Documentation',
        ]);



        $menuList = array_merge($menuList, [
            url('/')=>'Home',
            url('#break5')=>'<div style="border:1px solid silver"><!-- -break- ----> </div>',
            url('contact')=>'Contact Us',
            url('about')=>'About',
            url('founder')=>'About Founder',
            url('#break6')=>'<div style="border:1px solid silver"><!-- break-- -- ----> </div>',
            url('terms_and_condition')=>'Term and Condition',
            url('privacy_policy')=>'Privacy policy',
        ]);

        return $menuList;
    }



    /**
     * Top Menu Header Menu List
     */
    static function getMenuHeaderTop(){
        return [
            url('/')=>'Home',
            url('/product')=>'Products',
            url('/portfolio')=>'Portfolio',
            url('/about')=>'About',
            url('/contact')=>'Contact',
            //url('/blog')=>'Blog',
        ];
    }








    /**
     * Header Menu List
     */
    static function getMenuHeader(){
        return [
            url('/home')=>'Home',
            url('/product')=>'Product',
            url('/dashboard')=>'Account',
            //url('/blog')=>'Blog',
            url('/about')=>'About',
            url('/contact')=>'Contact',
        ];
    }


    /**
     * Header Menu List
     */
    static function getMenuFooter(){
        return [
            url('/home')=>'Home',
            //url('/blog')=>'Blog',
            //url('/about')=>'About',
            url('/contact')=>'Contact',
            //url('/privacy_policy')=>'Privacy Policy',
            url('/terms_and_condition')=>'Terms And Condition',
            //url('/site_map')=>'Sitemap',
        ];
    }


    /**
     * Footer Menu List
     */
    static function getFooterCopyrightBody(){
        return '<strong>Xamtax Technology</strong> All rights reserved - '.date('Y').' &copy; Powered by <a href="'.url('/ehex').'" target="_blank" title="Ehex (ex)">Xamtax Ehex</a>.';
    }

}

