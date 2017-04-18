from numpy import exp, array, random, dot

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
    training_inputs = array([[1,2,3],[2,3,4],[1,3,4]])
    training_outputs = array([[1,0.5,1]]).T
    neural_network.train(training_inputs, training_outputs, 10000)
    print neural_network.think(array([0,3,4]))