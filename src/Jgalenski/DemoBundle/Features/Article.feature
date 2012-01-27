Feature: ArticleRepository
    As a Developper
    I want to be abble to get Query from ArticleRepository Methods

    Background:
        Given There is no "Article" in database
        And I create 100 random Article entries

    Scenario: find all article
        When I want to get all articles
        Then I should get a Query object
    
    Scenario: find article by criteria
        When I want to get article with some random criteria
        Then I should get a Query object
    
    Scenario: find one article
        When I want to get one article
        Then I should get a Query object

    Scenario: Add an article
        When I am on "/new"
        Then I should see an ".controls" element
    
    Scenario: Add an article and get error
        When I am on "/new"
        And I press "Save"
        Then I should see an ".alert-error" element
    
    Scenario: Add an article and get success
        When I am on "/new"
        And I fill in "jgalenski_demobundle_articletype[title]" with "test"
        And I fill in "jgalenski_demobundle_articletype[content]" with "test"
        And I press "Save"
        Then I should see an ".alert-success" element