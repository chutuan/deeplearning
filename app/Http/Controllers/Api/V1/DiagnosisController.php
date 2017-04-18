<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\SymptomRepository;
use Illuminate\Http\Request;
use App\Diagnose;

class DiagnosisController extends Controller
{
  public function store(Request $request)
  {
    $symptoms = $request->get('symptoms');
    $trainingInputs = [];
    $trainingOutputs = [];
    $diagnosis = Diagnose::all();
    foreach($diagnosis as $diagnose)
    {
      array_push($trainingInputs,'[' . $diagnose->symptoms . ']');
      array_push($trainingOutputs, $diagnose->result);
    }
    $trainingInputs = implode(',', $trainingInputs);
    $trainingOutputs = '[' . implode(',', $trainingOutputs) . ']';
    file_put_contents(app_path('NeuralNetwork.py'), 
    "from numpy import exp, array, random, dot\r\n
class NeuralNetwork():
    def __init__(self):
        random.seed(1)
        self.weights = 2 * random.random((3, 1)) - 1
    def __sigmoid(self, x):
        # Ham chuan hoa
        # YT = 1 / (1 + exp(e(-Y)))
        return 1 / (1 + exp(-x))
    def __sigmoid_derivative(self, x):
        return x * (1 - x)
    def train(self, training_set_inputs, training_set_outputs, number_of_training_iterations):
        for iteration in xrange(number_of_training_iterations):
            output = self.think(training_set_inputs)
            # Cacuated Delta Error
            error = training_set_outputs - output
            # Adjust = error * inputs * (x * (1 - x))
            adjustment = dot(training_set_inputs.T, error * self.__sigmoid_derivative(output))
            self.weights += adjustment
    def think(self, inputs):
        # Y = Sum(Input[1..n]*weights)
        total = dot(inputs, self.weights)
        return self.__sigmoid(total)
if __name__ == '__main__':
    neural_network = NeuralNetwork()
    training_inputs = array([{$trainingInputs}])
    training_outputs = array([{$trainingOutputs}]).T
    neural_network.train(training_inputs, training_outputs, 10000)
    print neural_network.think(array([{$symptoms}]))");

    $neural = escapeshellcmd('python ' . app_path('NeuralNetwork.py'));
    echo shell_exec($neural);
  }
}