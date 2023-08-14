# ModemMessageSync

ModemMessageSync is a PHP package designed to simplify the synchronization and management of SMS messages obtained from a GSM modem. It provides tools to efficiently handle incoming SMS messages, decode Unicode content, and send notifications through various channels.

## Features

- Seamless synchronization of SMS messages from a GSM modem.
- Integration with Apprise for sending notifications.
- Support for sending notifications via MQTT.

## Installation

1. Open a terminal and navigate to the directory where you want to create your project.

2. Run the following Composer command to create a new ModemMessageSync project:

	```bash
	composer create-project asboldyrev/modem-message-sync your-project-name
	```
	Replace your-project-name with the desired name for your project directory.

3. Change into the newly created project directory:
	```bash
 	cd your-project-name
	```
 4. Create a .env file in the project root directory. You can use the provided .env.example as a template. Fill in the necessary environment variables such as SSH connection details, Apprise credentials, and other configuration options.

## Usage
Follow these steps to use ModemMessageSync:

Run PHP script to initiate the synchronization and management of SMS messages from the GSM modem:
```bash
php index.php
```

Or

1. Set up a cron job to automate the synchronization process. Open your crontab configuration by running:
	```bash
	crontab -e
	```
2. Add a line to specify the frequency of synchronization, replacing path_to_your_script with the actual path to your PHP script:
   ```
    * * * * * php /path_to_your_project/index.php
    ```

## Configuration
You can configure the package by setting the required environment variables in a .env file. Refer to the example .env.example file for the list of variables.

## License
ModemMessageSync is open-source software licensed under the MIT License.
Feel free to contribute to this project or report any issues you encounter.

© 2023 asboldyrev
