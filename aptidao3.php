<?php
interface Command {
  public function execute();
  public function undo();
}

class AddCommand implements Command {
  private $calculator;
  private $valueToAdd;

  public function __construct($calculator, $value) {
      $this->calculator = $calculator;
      $this->valueToAdd = $value;
  }

  public function execute() {
      $this->calculator->add($this->valueToAdd);
  }

  public function undo() {
      $this->calculator->subtract($this->valueToAdd);
  }
}

class Calculator {
  private $total = 0;

  public function add($value) {
      $this->total += $value;
      echo "Adicionando $value. Total: {$this->total}\n";
  }

  public function subtract($value) {
      $this->total -= $value;
      echo "Subtraindo $value. Total: {$this->total}\n";
  }
}

class Invoker {
  private $commands = [];
  private $redoCommands = [];

  public function executeCommand(Command $command) {
      $command->execute();
      $this->commands[] = $command;
  }

  public function undoLastCommand() {
      if (!empty($this->commands)) {
          $command = array_pop($this->commands);
          $command->undo();
          $this->redoCommands[] = $command;
      } else {
          echo "Nenhum comando para desfazer.\n";
      }
  }

  public function redoLastCommand() {
      if (!empty($this->redoCommands)) {
          $command = array_pop($this->redoCommands);
          $command->execute();
          $this->commands[] = $command;
      } else {
          echo "Nenhum comando para refazer.\n";
      }
  }
}

// Utilização
$calculator = new Calculator();
$invoker = new Invoker();

$command1 = new AddCommand($calculator, 10);
$command2 = new AddCommand($calculator, 5);

$invoker->executeCommand($command1);  // Adicionando 10. Total: 10
$invoker->executeCommand($command2);  // Adicionando 5. Total: 15

$invoker->undoLastCommand();          // Subtraindo 5. Total: 10
$invoker->redoLastCommand();          // Adicionando 5. Total: 15

?>
