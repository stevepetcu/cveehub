<?php declare(strict_types=1);

use Behat\Gherkin\Node\TableNode;
use CVeeHub\Infrastructure\Testing\SqliteDatabasePopulator;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * Populates database before each Scenario and purges it afterwards.
 */
class SqlDatabaseBootstrapContext extends FunctionalBootstrapContext
{
    /** @var  Application */
    protected $application;

    /** @var  SqliteDatabasePopulator */
    protected $dbPopulator;

    public function __construct($environment, $constantsPath, $containerPath)
    {
        parent::__construct($environment, $constantsPath, $containerPath);

        $this->application = static::$container->get(Application::class);

        // We want to display any exceptions which may occur during database bootstrapping.
        $this->application->setCatchExceptions(false);

        // Set auto exit to false, otherwise all execution will stop after the command is finished running.
        $this->application->setAutoExit(false);

        $this->dbPopulator = static::$container->get(SqliteDatabasePopulator::class);
    }

    /**
     * @BeforeScenario
     *
     * Setup our database schema. This hook runs before each
     * Scenario, before the Feature's Background hook.
     */
    public function beforeScenario()
    {
        $this->afterScenario();

        $input = new ArrayInput([
                'command' => 'orm:schema-tool:create'
            ]
        );

        $output = new NullOutput();

        $this->application->run($input, $output);
    }

    /**
     * @AfterScenario
     *
     * Tear down database. This hook will run after each Scenario.
     */
    public function afterScenario()
    {
        $input = new ArrayInput([
                'command' => 'orm:schema-tool:drop',
                '--force' => true
            ]
        );

        $output = new NullOutput();

        $this->application->run($input, $output);
    }

    private function populateDatabaseTable(string $table, TableNode $data)
    {
        $this->dbPopulator->setTable($table);

        $hash = $data->getHash();

        foreach ($hash as $row) {
            $this->dbPopulator->setData($row)->save();
        }
    }

    /**
     * @Given the following statuses exist:
     */
    public function theFollowingStatusesExist(TableNode $data)
    {
        $this->populateDatabaseTable('account_status', $data);
    }

    /**
     * @Given the following website types exist:
     */
    public function theFollowingWebsiteTypesExist(TableNode $data)
    {
        $this->populateDatabaseTable('website_type', $data);
    }

    /**
     * @Given the following industries exist:
     */
    public function theFollowingIndustriesExist(TableNode $data)
    {
        $this->populateDatabaseTable('industry', $data);
    }

    /**
     * @Given the following countries exist:
     */
    public function theFollowingCountriesExist(TableNode $data)
    {
        $this->populateDatabaseTable('country', $data);
    }

    /**
     * @Given the following user accounts are registered:
     */
    public function theFollowingUserAccountsAreRegistered(TableNode $data)
    {
        $this->populateDatabaseTable('user_account', $data);
    }

    /**
     * @Given the following emails are registered:
     */
    public function theFollowingEmailsAreRegistered(TableNode $data)
    {
        $this->populateDatabaseTable('email', $data);
    }

    /**
     * @Given the following phone numbers are registered:
     */
    public function theFollowingPhoneNumbersAreRegistered(TableNode $data)
    {
        $this->populateDatabaseTable('phone_number', $data);
    }

    /**
     * @Given the following addresses are registered:
     */
    public function theFollowingAddressesAreRegistered(TableNode $data)
    {
        $this->populateDatabaseTable('address', $data);
    }

    /**
     * @Given the following websites are registered:
     */
    public function theFollowingWebsitesAreRegistered(TableNode $data)
    {
        $this->populateDatabaseTable('website', $data);
    }
}
